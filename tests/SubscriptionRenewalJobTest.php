<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Tithe\Jobs\SubscriptionRenewalJob;
use Tithe\Tests\Mocks\Team;
use Tithe\Tithe;

test('subscription due for renewal can be renewed', function () {
    Bus::fake();

    Carbon::setTestNow(now());

    $plan = Tithe::newPlanModel()::factory()->create();
    $subscriber = Team::factory()->create();
    $subscription = Tithe::newSubscriptionModel()::factory()
        ->for($plan)
        ->for($subscriber, 'subscriber')
        ->create([
            'expired_at' => now(),
            'grace_days_ended_at' => now()->addDays(3)
        ]);

    SubscriptionRenewalJob::dispatch();

    Bus::assertDispatched(SubscriptionRenewalJob::class);
});