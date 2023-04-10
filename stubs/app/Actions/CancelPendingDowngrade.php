<?php

namespace App\Actions\Tithe;

use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Validator;
use Tithe\Contracts\CancelsPendingDowngrades;

class CancelPendingDowngrade implements CancelsPendingDowngrades
{
    /**
     * Cancel a pending downgrade of the provided subscriber.
     */
    public function cancel(mixed $user, mixed $subscriber): void
    {
        Gate::forUser($user)->authorize('update', $subscriber);

        try {
            $this->ensurePendingDowngradeCanBeCancelled($subscriber);

            DB::transaction(function () use ($subscriber) {
                $fallbackSubscription = $subscriber->fallback_subscription;
                $invoice = $fallbackSubscription->subscriptionInvoices()
                    ->whereSubscriberType(get_class($subscriber))
                    ->whereSubscriberId($subscriber->id)
                    ->whereNull('paid_at')
                    ->first();

                // Delete the fallback subscription and invoice that were created
                // during the switch
                $fallbackSubscription->delete();
                $invoice->delete();

                $subscriber->subscription->update([
                    'was_switched' => false,
                ]);
            });
        } catch (\Throwable $th) {
            report($th);
            Facades\Validator::make([], [])->after(function (Validator $validator) use ($th) {
                $validator->errors()->add(
                    'cancel-pending-downgrade-error', $th->getMessage()
                );
            })->validateWithBag('cancelPendingDowngrade');
        }
    }

    /**
     * Ensures current subscription can be downgraded.
     */
    protected function ensurePendingDowngradeCanBeCancelled(mixed $subscriber): void
    {
        throw_if(! $subscriber->hasPendingSwitch(), 'Exception', 'This subscriber does not have a pending downgrade');
    }
}
