<?php

namespace App\Actions\Tithe;

use StarfolkSoftware\Paystack\Client as PaystackClient;
use Tithe\Contracts\RenewsSubscriptions;
use Tithe\Tithe;

class RenewSubscription implements RenewsSubscriptions
{
    /**
     * Holds the payment reference.
     */
    protected string $reference;

    /**
     * Validate and renew the given subscriber's subscription.
     */
    public function renew(mixed $subscription): void
    {
        $this->ensureSubscriptionCanBeRenewed($subscription);

        $subscriber = $subscription->subscriber;

        $subscription = ! $subscriber->hasPendingDowngrade() ?
            $subscription :
            (object) [
                'plan' => Tithe::planModel()::whereName(data_get($subscription->meta, 'to_plan'))->first(),
                'subscriber' => $subscriber,
                'expired_at' => $subscription->expired_at,
            ];

        $this->charge($subscription);

        if ($subscriber->hasPendingDowngrade()) {
            $startDate = $subscription->expired_at;
            $subscriber->subscribeTo($subscription->plan, startDate: $startDate);
        } else {
            $subscription->renew();
        }

        $subscriber->subscriptionInvoices()->create([
            'subscription_id' => $subscriber->fresh()->subscription->id,
            'paid_at' => now(),
            'meta' => [
                'action' => 'renewal',
                'paystack_transaction_reference' => $this->reference,
            ],
        ]);

    }

    /**
     * Charge and confirms payment.
     */
    protected function charge(mixed $subscription): bool
    {
        $amount = $subscription?->plan->amount;
        $subscriber = $subscription?->subscriber;

        if ($amount == 0) {
            return true;
        }

        $paystack = new PaystackClient([
            'secretKey' => config('tithe.paystack.secret_key'),
        ]);

        $authCode = $subscriber?->defaultAuthorization()?->code;

        throw_if(! $authCode, 'Exception', "Couldn't find a payment method.");

        $chargeResponse = $paystack->transactions
            ->charge([
                'amount' => (string) $amount,
                'email' => $subscriber->titheEmail(),
                'authorization_code' => $authCode,
            ]);

        $reference = data_get($chargeResponse, 'data.reference');

        throw_if(! $reference, 'Exception', "Payment couldn't be confirmed.");

        $confirmationResponse = $paystack->transactions
            ->verify($reference);

        throw_if(! $confirmationResponse['status'] ||
            data_get($confirmationResponse, 'data.status') != 'success',
            'Exception',
            'Couldnt confirm payment. Kindly, try again!'
        );

        $this->reference = $reference;

        return true;
    }

    /**
     * Ensures subscription can be renewed.
     */
    protected function ensureSubscriptionCanBeRenewed(mixed $subscription): void
    {
        throw_if(
            ! $subscription->isDueForRenewal(),
            'Exception',
            'Subscription can not be renewed.'
        );
    }
}
