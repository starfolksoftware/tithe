<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Bus;
use Tithe\Jobs\HandleSubscriptionOverdueJob;
use Tithe\Tests\Mocks\Team;
use Tithe\Tithe;

test('overdue subscriptions can be handled', function () {
    Bus::fake();

    Carbon::setTestNow(now());

    $plan = Tithe::newPlanModel()::factory()->create();
    $subscriber = Team::factory()->create();
    $subscription = Tithe::newSubscriptionModel()::factory()
        ->for($plan)
        ->for($subscriber, 'subscriber')
        ->create([
            'expired_at' => now()->subDays(6),
            'grace_days_ended_at' => now()->subDays(3),
        ]);

    HandleSubscriptionOverdueJob::dispatch();

    Bus::assertDispatched(HandleSubscriptionOverdueJob::class);
});
