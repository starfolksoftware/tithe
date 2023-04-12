<?php

namespace Tithe\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Tithe\Contracts\RenewsSubscriptions;
use Tithe\Notifications\SubscriptionRenewalFailed;
use Tithe\Tithe;

class SubscriptionRenewalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach (Tithe::subscriptionModel()::dueForRenewal()->cursor() as $subscription) {
            try {
                app(RenewsSubscriptions::class)->renew($subscription);
            } catch (\Throwable $th) {
                report($th);

                Notification::route('mail', $subscription->subscriber->titheEmail())
                    ->notify(new SubscriptionRenewalFailed($subscription->subscriber));
            }
        }
    }
}
