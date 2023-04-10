<?php

namespace Tithe\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Tithe\Contracts\HandlesOverdueSubscriptions;
use Tithe\Tithe;

class HandleSubscriptionOverdueJob implements ShouldQueue
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
        foreach (Tithe::subscriptionModel()::overdue()->cursor() as $subscription) {
            try {
                app(HandlesOverdueSubscriptions::class)->handle($subscription);
            } catch (\Throwable $th) {
                report($th);
            }
        }
    }
}
