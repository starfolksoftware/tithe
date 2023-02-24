<?php

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Tithe\Events\SubscriptionCanceled;
use Tithe\Events\SubscriptionRenewed;
use Tithe\Events\SubscriptionStarted;
use Tithe\Events\SubscriptionSuppressed;
use Tithe\Tests\Mocks\Team;
use Tithe\Tithe;

beforeAll(function () {
    setTestModels();
});

uses(WithFaker::class);

test('subscriber can renew subscription', function () {
    Event::fake();

    Carbon::setTestNow(now());

    $plan = Tithe::newPlanModel()::factory()->create();
    $subscriber = Team::factory()->create();
    $subscription = Tithe::newSubscriptionModel()::factory()
        ->for($plan)
        ->for($subscriber, 'subscriber')
        ->create([
            'expired_at' => now()->addDay(),
        ]);

    $expectedExpiredAt = $plan->calculateNextRecurrenceEnd($subscription->expired_at)->toDateTimestring();
    $subscription->renew();
    Event::assertDispatched(SubscriptionRenewed::class);
    $this->assertDatabaseHas('subscriptions', [
        'plan_id' => $plan->id,
        'subscriber_id' => $subscriber->id,
        'subscriber_type' => Team::class,
        'expired_at' => $expectedExpiredAt,
    ]);
});

test('subscriber model renews based on current date if overdue', function () {
    Event::fake();
    Carbon::setTestNow(now());

    $plan = Tithe::newPlanModel()::factory()->create();
    $subscriber = Team::factory()->create();
    $subscription = Tithe::newSubscriptionModel()::factory()
        ->for($plan)
        ->for($subscriber, 'subscriber')
        ->create([
            'expired_at' => now()->subDay(),
        ]);

    $expectedExpiredAt = $plan->calculateNextRecurrenceEnd()->toDateTimeString();

    $subscription->renew();

    Event::assertDispatched(SubscriptionRenewed::class);

    $this->assertDatabaseHas('subscriptions', [
        'plan_id' => $plan->id,
        'subscriber_id' => $subscriber->id,
        'subscriber_type' => Team::class,
        'expired_at' => $expectedExpiredAt,
    ]);
});

test('subscriber model can cancel subscription', function () {
    Event::fake();
    Carbon::setTestNow(now());

    $plan = Tithe::newPlanModel()::factory()->create();
    $subscriber = Team::factory()->create();
    $subscription = Tithe::newSubscriptionModel()::factory()
        ->for($plan)
        ->for($subscriber, 'subscriber')
        ->notStarted()
        ->create();

    $subscription->cancel();

    Event::assertDispatched(SubscriptionCanceled::class);

    $this->assertDatabaseHas('subscriptions', [
        'id' => $subscription->id,
        'canceled_at' => now(),
    ]);
});

test('subscriber model can start a subscription', function () {
    Event::fake();
    Carbon::setTestNow(now());

    $plan = Tithe::newPlanModel()::factory()->create();
    $subscriber = Team::factory()->create();
    $subscription = Tithe::newSubscriptionModel()::factory()
        ->for($plan)
        ->for($subscriber, 'subscriber')
        ->notStarted()
        ->create();

    $subscription->start();

    Event::assertDispatched(SubscriptionStarted::class);

    $this->assertDatabaseHas('subscriptions', [
        'id' => $subscription->id,
        'started_at' => today(),
    ]);
});

test('subscriber model can suppress a subscription', function () {
    Event::fake();
    Carbon::setTestNow(now());

    $plan = Tithe::newPlanModel()::factory()->create();
    $subscriber = Team::factory()->create();
    $subscription = Tithe::newSubscriptionModel()::factory()
        ->for($plan)
        ->for($subscriber, 'subscriber')
        ->create();

    $subscription->suppress();

    Event::assertDispatched(SubscriptionSuppressed::class);

    $this->assertDatabaseHas('subscriptions', [
        'id' => $subscription->id,
        'suppressed_at' => now(),
    ]);
});

test('subscriber model can mark a subscription as switched', function () {
    $plan = Tithe::newPlanModel()::factory()->create();
    $subscriber = Team::factory()->create();
    $subscription = Tithe::newSubscriptionModel()::factory()
        ->for($plan)
        ->for($subscriber, 'subscriber')
        ->create();

    $subscription->markSwitched()->save();

    $this->assertDatabaseHas('subscriptions', [
        'id' => $subscription->id,
        'was_switched' => true,
    ]);
});

test('subscriber model can register a renewal', function () {
    $subscriber = Team::factory()->create();
    $subscription = Tithe::newSubscriptionModel()::factory()
        ->for($subscriber, 'subscriber')
        ->create();

    $subscription->renew();

    $this->assertDatabaseCount('subscription_renewals', 1);
    $this->assertDatabaseHas('subscription_renewals', [
        'subscription_id' => $subscription->id,
        'renewal' => true,
    ]);
});

test('subscriber model can register overdue', function () {
    $subscriber = Team::factory()->create();
    $subscription = Tithe::newSubscriptionModel()::factory()
        ->for($subscriber, 'subscriber')
        ->create([
            'expired_at' => now()->subDay(),
        ]);

    $subscription->renew();

    $this->assertDatabaseCount('subscription_renewals', 1);
    $this->assertDatabaseHas('subscription_renewals', [
        'subscription_id' => $subscription->id,
        'overdue' => true,
    ]);
});

test('subscriber model considers grace days on overdue', function () {
    $subscriber = Team::factory()->create();
    $subscription = Tithe::newSubscriptionModel()::factory()
        ->for($subscriber, 'subscriber')
        ->create([
            'grace_days_ended_at' => now()->addDay(),
            'expired_at' => now()->subDay(),
        ]);

    $subscription->renew();

    $this->assertDatabaseCount('subscription_renewals', 1);
    $this->assertDatabaseHas('subscription_renewals', [
        'subscription_id' => $subscription->id,
        'overdue' => false,
    ]);
});

test('subscription not active scope returns subscriptions that have not started', function () {
    Tithe::newSubscriptionModel()::factory()
        ->count($this->faker()->randomDigitNotNull())
        ->started()
        ->notExpired()
        ->notSuppressed()
        ->create();

    $notStartedSubscription = Tithe::newSubscriptionModel()::factory()
        ->count($notStartedSubscriptionCount = $this->faker()->randomDigitNotNull())
        ->notStarted()
        ->notExpired()
        ->notSuppressed()
        ->create();

    $returnedSubscriptions = Tithe::newSubscriptionModel()->notActive()->get();

    $this->assertCount($notStartedSubscriptionCount, $returnedSubscriptions);
    $notStartedSubscription->each(
        fn ($subscription) => $this->assertContains($subscription->id, $returnedSubscriptions->pluck('id'))
    );
});

test('subscription not active scope returns subscriptions that expired', function () {
    Tithe::newSubscriptionModel()::factory()
        ->count($this->faker()->randomDigitNotNull())
        ->started()
        ->notExpired()
        ->notSuppressed()
        ->create();

    $expiredSubscription = Tithe::newSubscriptionModel()::factory()
        ->count($expiredSubscriptionCount = $this->faker()->randomDigitNotNull())
        ->started()
        ->expired()
        ->notSuppressed()
        ->create();

    $returnedSubscriptions = Tithe::newSubscriptionModel()::notActive()->get();

    $this->assertCount($expiredSubscriptionCount, $returnedSubscriptions);
    $expiredSubscription->each(
        fn ($subscription) => $this->assertContains($subscription->id, $returnedSubscriptions->pluck('id'))
    );
});

test('subscription not active scope returns subscriptions that are suppressed', function () {
    Tithe::newSubscriptionModel()::factory()
        ->count($this->faker()->randomDigitNotNull())
        ->started()
        ->notExpired()
        ->notSuppressed()
        ->create();

    $suppressedSubscription = Tithe::newSubscriptionModel()::factory()
        ->count($suppressedSubscriptionCount = $this->faker()->randomDigitNotNull())
        ->started()
        ->notExpired()
        ->suppressed()
        ->create();

    $returnedSubscriptions = Tithe::newSubscriptionModel()::notActive()->get();

    $this->assertCount($suppressedSubscriptionCount, $returnedSubscriptions);

    $suppressedSubscription->each(
        fn ($subscription) => $this->assertContains($subscription->id, $returnedSubscriptions->pluck('id'))
    );
});

test('subscription canceled scope', function () {
    Tithe::newSubscriptionModel()::factory()
        ->count($this->faker()->randomDigitNotNull())
        ->started()
        ->notExpired()
        ->notSuppressed()
        ->notCanceled()
        ->create();

    $canceledSubscription = Tithe::newSubscriptionModel()::factory()
        ->count($canceledSubscriptionCount = $this->faker()->randomDigitNotNull())
        ->started()
        ->notExpired()
        ->notSuppressed()
        ->canceled()
        ->create();

    $returnedSubscriptions = Tithe::newSubscriptionModel()::canceled()->get();

    $this->assertCount($canceledSubscriptionCount, $returnedSubscriptions);
    $canceledSubscription->each(
        fn ($subscription) => $this->assertContains($subscription->id, $returnedSubscriptions->pluck('id'))
    );
});

test('subscription not canceled scope', function () {
    Tithe::newSubscriptionModel()::factory()
        ->count($this->faker()->randomDigitNotNull())
        ->started()
        ->notExpired()
        ->notSuppressed()
        ->canceled()
        ->create();

    $notCanceledSubscription = Tithe::newSubscriptionModel()::factory()
        ->count($notCanceledSubscriptionCount = $this->faker()->randomDigitNotNull())
        ->started()
        ->notExpired()
        ->notSuppressed()
        ->notCanceled()
        ->create();

    $returnedSubscriptions = Tithe::newSubscriptionModel()::notCanceled()->get();

    $this->assertCount($notCanceledSubscriptionCount, $returnedSubscriptions);
    $notCanceledSubscription->each(
        fn ($subscription) => $this->assertContains($subscription->id, $returnedSubscriptions->pluck('id'))
    );
});
