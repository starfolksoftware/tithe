<?php

namespace App\Actions\Tithe;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Tithe\Contracts\CreatesAuthorizations;
use StarfolkSoftware\Paystack\Client as PaystackClient;
use Tithe\Tithe;

class CreateAuthorization implements CreatesAuthorizations
{
    /**
     * Validate and create a new authorization for the given subscriber.
     *
     * @param  mixed  $user
     * @param  mixed  $subscriber
     * @param  string $reference
     * @return mixed
     */
    public function create($user, $subscriber, string $reference)
    {
        Gate::forUser($user)->authorize('create', Tithe::newCreditCardAuthorizationModel());

        $input = $this->confirmsPayment($reference);

        Validator::make($input, [
            'authorization' => ['array:authorization_code,signature,type,last4,exp_month,exp_year,bin,bank,account_name,country_code'],
            'customer' => ['array:email,'],
        ])->validateWithBag('createAuthorization');

        $creditCard = Tithe::creditCardModel()::firstOrCreate(
            ['signature' => data_get($input, 'authorization.signature')],
            collect($input['authorization'])->only([
                'type',
                'last4',
                'exp_month',
                'exp_year',
                'bin',
                'bank',
                'account_name',
                'country_code'
            ])->toArray()
        );

        return Tithe::creditCardAuthorizationModel()::firstOrCreate([
            'subscriber_id' => $subscriber->id,
            'subscriber_type' => get_class($subscriber),
            Tithe::newCreditCardModel()->getForeignKey() => $creditCard->id,
        ], [
            'email' => data_get($input, 'customer.email'),
            'code' => data_get($input, 'authorization.authorization_code')
        ]);
    }

    /**
     * Confirms paystack payment.
     */
    protected function confirmsPayment(string $reference): array
    {
        $paystack = new PaystackClient(['secretKey' => config('tithe.paystack.secret_key')]);

        $confirmationResponse = $paystack
            ->transactions
            ->verify($reference);

        throw_if(!$confirmationResponse['status'] || data_get($confirmationResponse, 'data.status') != 'success',
            'Exception',
            'Couldnt confirm payment. Kindly, try again!'
        );

        return $confirmationResponse['data'];
    }
}
