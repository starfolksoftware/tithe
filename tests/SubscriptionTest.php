<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Tithe\Tests\Mocks\Subscription;
use Tithe\Tests\Mocks\Team;
use Tithe\Tithe;

beforeAll(function () {
    setTestModels();
});

test("subscriber can renew subscription", function () {
    Carbon::setTestNow(now());

    $plan = Tithe::newPlanModel()::factory()->create();
    $subscriber = Team::factory()->create();
    $subscription = Subscription::factory()
        ->for($plan)
        ->for($subscriber, 'subscriber')
        ->create([
            'expired_at' => now()->addDay()
        ]);

    $expectedExpiredAt = $plan->calculateNextRecurrenceEnd($subscription->expired_at)->toDateTimestring();
    Event::fake();
    $subscription->renew();
    Event::assertDispatched(SubscriptionRenewed::class);
    $this->assertDatabaseHas('subscriptions', [
        'plan_id' => $plan->id,
        'subscriber_id' => $subscriber->id,
        'subscriber_type' => User::class,
        'expired_at' => $expectedExpiredAt,
    ]);
});