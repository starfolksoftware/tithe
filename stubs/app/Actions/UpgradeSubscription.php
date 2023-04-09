<?php

namespace App\Actions\Tithe;

use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Validator;
use StarfolkSoftware\Paystack\Client as PaystackClient;
use Tithe\Contracts\UpgradesSubscriptions;
use Tithe\Enums\PeriodicityTypeEnum;

class UpgradeSubscription implements UpgradesSubscriptions
{
    /**
     * Holds the payment reference.
     */
    public string $reference;

    /**
     * Validate and upgrade the given subscriber's subscription.
     */
    public function upgrade(mixed $user, mixed $subscriber, mixed $plan): void
    {
        Gate::forUser($user)->authorize('update', $subscriber);

        $prorationAmount = PeriodicityTypeEnum::proration($subscriber, $plan);

        try {
            $this->ensureCurrentSubscriptionCanBeUpgraded(
                $subscriber,
                $plan
            );

            $currentPlan = $subscriber->subscription?->plan;

            if ($this->charge($prorationAmount, $subscriber)) {
                match (true) {
                    (bool) $subscriber->subscription => $subscriber->switchTo(
                        $plan,
                        immediately: true
                    ),
                    ! (bool) $subscriber->subscription => $subscriber->subscribeTo($plan)
                };

                $subscriber->subscriptionInvoices()->create([
                    'subscription_id' => $subscriber->fresh()->subscription->id,
                    'paid_at' => now(),
                    'meta' => [
                        'action' => 'upgrade',
                        'from' => $currentPlan->name,
                        'to' => $plan->name,
                        'paystack_transaction_reference' => $this->reference,
                    ],
                ]);
            }
        } catch (\Throwable $th) {
            report($th);
            Facades\Validator::make([], [])->after(function (Validator $validator) use ($th) {
                $validator->errors()->add(
                    'upgrade-error', $th->getMessage()
                );
            })->validateWithBag('upgradeSubscription');
        }
    }

    /**
     * Charge and confirms payment.
     */
    protected function charge(float $amount, mixed $subscriber): bool
    {
        if ($amount == 0) {
            return true;
        }

        $paystack = new PaystackClient([
            'secretKey' => config('tithe.paystack.secret_key'),
        ]);

        $authCode = $subscriber->defaultAuthorization()?->code;

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
     * Ensures current subscription can be upgraded.
     */
    protected function ensureCurrentSubscriptionCanBeUpgraded(mixed $subscriber, $newPlan): void
    {
        $oldPlan = $subscriber->subscription?->plan;

        throw_if(
            (! is_null($oldPlan) &&
            $newPlan->amount <= $oldPlan->amount) ||
            $subscriber->hasPendingSwitch(),
            'Exception',
            'Current subscription can not be upgraded.'
        );
    }
}
