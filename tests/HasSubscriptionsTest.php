<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tithe\Tithe;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Tithe\CountsQueries;
use Tithe\Events\FeatureConsumed;
use Tithe\Events\FeatureTicketCreated;
use Tithe\Events\SubscriptionScheduled;
use Tithe\Events\SubscriptionStarted;
use Tithe\Events\SubscriptionSuppressed;
use Tithe\Tests\Mocks\Team;

beforeAll(function () {
    setTestModels();
});

uses(WithFaker::class);
uses(CountsQueries::class);

test('subscriber can subscribe to a plan', function () {
    $plan = Tithe::planModel()::factory()->createOne();
    $subscriber = Team::factory()->createOne();

    Event::fake();

    $subscription = $subscriber->subscribeTo($plan);

    Event::assertDispatched(SubscriptionStarted::class);

    $this->assertDatabaseHas('subscriptions', [
        'id' => $subscription->id,
        'plan_id' => $plan->id,
        'subscriber_id' => $subscriber->id,
        'started_at' => today(),
        'expired_at' => $plan->calculateNextRecurrenceEnd(),
        'grace_days_ended_at' => null,
    ]);
});

test('grace days end is calculated when a subscriber subscribes', function () {
    $plan = Tithe::planModel()::factory()
        ->withGraceDays()
        ->createOne();

    $subscriber = Team::factory()->createOne();
    $subscription = $subscriber->subscribeTo($plan);

    $this->assertDatabaseHas('subscriptions', [
        'grace_days_ended_at' => $plan->calculateGraceDaysEnd($subscription->expired_at),
    ]);
});

test('subscriber can switch to a plan', function () {
    Carbon::setTestNow(now());

    $oldPlan = Tithe::newPlanModel()::factory()->createOne();
    $newPlan = Tithe::newPlanModel()::factory()->createOne();

    $subscriber = Team::factory()->createOne();
    $oldSubscription = $subscriber->subscribeTo($oldPlan);

    Event::fake();

    $newSubscription = $subscriber->switchTo($newPlan);

    Event::assertDispatched(SubscriptionStarted::class);
    Event::assertDispatched(SubscriptionSuppressed::class);

    $this->assertDatabaseHas('subscriptions', [
        'id' => $newSubscription->id,
        'plan_id' => $newPlan->id,
        'subscriber_id' => $subscriber->id,
        'started_at' => today(),
        'expired_at' => $newPlan->calculateNextRecurrenceEnd(),
    ]);

    $this->assertDatabaseHas('subscriptions', [
        'id' => $oldSubscription->id,
        'suppressed_at' => now(),
        'was_switched' => true,
    ]);
});

test('subscriber can schedule a switch to a plan', function () {
    Carbon::setTestNow(now());

    $oldPlan = Tithe::newPlanModel()::factory()->createOne();
    $newPlan = Tithe::newPlanModel()::factory()->createOne();

    $subscriber = Team::factory()->createOne();
    $oldSubscription = $subscriber->subscribeTo($oldPlan);

    Event::fake();

    $newSubscription = $subscriber->switchTo($newPlan, immediately: false);

    Event::assertDispatched(SubscriptionScheduled::class);
    Event::assertNotDispatched(SubscriptionStarted::class);

    $this->assertDatabaseHas('subscriptions', [
        'id' => $newSubscription->id,
        'plan_id' => $newPlan->id,
        'started_at' => $oldSubscription->expired_at,
        'expired_at' => $newPlan->calculateNextRecurrenceEnd($oldSubscription->expired_at),
    ]);

    $this->assertDatabaseHas('subscriptions', [
        'id' => $oldSubscription->id,
        'was_switched' => true,
    ]);
});

test('subscriber has new subscription after switch', function () {
    $oldPlan = Tithe::newPlanModel()::factory()->createOne();
    $newPlan = Tithe::newPlanModel()::factory()->createOne();

    $subscriber = Team::factory()->createOne();
    $subscriber->subscribeTo($oldPlan, startDate: now()->subDay());

    $newSubscription = $subscriber->switchTo($newPlan);

    $this->assertTrue($newSubscription->is($subscriber->fresh()->subscription));
});

test('when a switch is scheduled, subscriber returns current subscription', function () {
    Carbon::setTestNow(now());

    $oldPlan = Tithe::planModel()::factory()->createOne();
    $newPlan = Tithe::planModel()::factory()->createOne();

    $subscriber = Team::factory()->createOne();
    $oldSubscription = $subscriber->subscribeTo($oldPlan);

    $subscriber->switchTo($newPlan, immediately: false);

    $this->assertTrue($oldSubscription->is($subscriber->fresh()->subscription));
});

test('subscriber can consume a feature', function () {
    $charges = $this->faker->numberBetween(5, 10);
    $consumption = $this->faker->numberBetween(1, $charges);

    $plan = Tithe::planModel()::factory()->createOne();
    $feature = Tithe::featureModel()::factory()->consumable()->createOne();
    $feature->plans()->attach($plan, [
        'charges' => $charges,
    ]);

    $subscriber = Team::factory()->createOne();
    $subscription = $subscriber->subscribeTo($plan);

    Event::fake();

    $subscriber->consume($feature->name, $consumption);

    Event::assertDispatched(FeatureConsumed::class);

    $this->assertDatabaseHas('feature_consumptions', [
        'consumption' => $consumption,
        'feature_id' => $feature->id,
        'subscriber_id' => $subscriber->id,
        'expired_at' => $feature->calculateNextRecurrenceEnd($subscription->started_at),
    ]);
});

test('subscriber can have access to non-consumable feature', function () {
    $plan = Tithe::planModel()::factory()->createOne();
    $feature = Tithe::featureModel()::factory()->notConsumable()->createOne();
    $feature->plans()->attach($plan);

    $subscriber = Team::factory()->createOne();
    $subscriber->subscribeTo($plan);

    $subscriber->consume($feature->name);

    $this->assertDatabaseHas('feature_consumptions', [
        'consumption' => null,
        'feature_id' => $feature->id,
        'subscriber_id' => $subscriber->id,
    ]);
});

test('subscriber cant consume a feature that is not available', function () {
    $charges = $this->faker->numberBetween(5, 10);
    $consumption = $this->faker->numberBetween(1, $charges);

    $plan = Tithe::planModel()::factory()->createOne();
    $feature = Tithe::featureModel()::factory()->consumable()->createOne();
    $feature->plans()->attach($plan, [
        'charges' => $charges,
    ]);

    $subscriber = Team::factory()->createOne();
    $subscriber->subscribeTo($plan, now()->subDay());

    $this->expectException(OutOfBoundsException::class);
    $this->expectExceptionMessage('None of the active plans grants access to this feature.');

    $subscriber->consume($feature->name, $consumption);

    $this->assertDatabaseMissing('feature_consumptions', [
        'consumption' => $consumption,
        'feature_id' => $feature->id,
        'subscriber_id' => $subscriber->id,
    ]);
});

test('model cant consume more than the unconsumed count of a feature', function () {
    $charges = $this->faker->numberBetween(5, 10);
    $consumption = $charges + 1;

    $plan = Tithe::planModel()::factory()->createOne();
    $feature = Tithe::featureModel()::factory()->consumable()->createOne();
    $feature->plans()->attach($plan, [
        'charges' => $charges,
    ]);

    $subscriber = Team::factory()->createOne();
    $subscriber->subscribeTo($plan);

    $this->expectException(OverflowException::class);
    $this->expectExceptionMessage('The feature has no enough charges to this consumption.');

    $subscriber->consume($feature->name, $consumption);

    $this->assertDatabaseMissing('feature_consumptions', [
        'consumption' => $consumption,
        'feature_id' => $feature->id,
        'subscriber_id' => $subscriber->id,
    ]);
});

test('subscriber can consume a consumable feature', function () {
    $charges = $this->faker->numberBetween(5, 10);
    $consumption = $this->faker->numberBetween(1, $charges);

    $plan = Tithe::planModel()::factory()->createOne();
    $feature = Tithe::featureModel()::factory()->consumable()->createOne();
    $feature->plans()->attach($plan, [
        'charges' => $charges,
    ]);

    $subscriber = Team::factory()->createOne();
    $subscriber->subscribeTo($plan);

    $modelCanUse = $subscriber->canConsume($feature->name, $consumption);

    $this->assertTrue($modelCanUse);
});

test('subscriber cant consume a consumable feature from an expired subscription', function () {
    $charges = $this->faker->numberBetween(5, 10);
    $consumption = $this->faker->numberBetween(1, $charges);

    $plan = Tithe::planModel()::factory()->createOne();
    $feature = Tithe::featureModel()::factory()->consumable()->createOne();
    $feature->plans()->attach($plan, [
        'charges' => $charges,
    ]);

    $subscriber = Team::factory()->createOne();
    $subscriber->subscribeTo($plan, now()->subDay());

    $modelCanUse = $subscriber->canConsume($feature->name, $consumption);

    $this->assertFalse($modelCanUse);
});

test('subscriber cant consume more than the available of a consummable feature', function () {
    $charges = $this->faker->numberBetween(5, 10);
    $consumption = $charges + 1;

    $plan = Tithe::planModel()::factory()->createOne();
    $feature = Tithe::featureModel()::factory()->consumable()->createOne();
    $feature->plans()->attach($plan, [
        'charges' => $charges,
    ]);

    $subscriber = Team::factory()->createOne();
    $subscriber->subscribeTo($plan);

    $modelCanUse = $subscriber->canConsume($feature->name, $consumption);

    $this->assertFalse($modelCanUse);
});

test('subscriber can consume a consummable feature in a new cycle after exhausting quota from a previous cycle', function () {
    $charges = $this->faker->numberBetween(5, 10);
    $consumption = $this->faker->numberBetween(1, $charges);

    $plan = Tithe::planModel()::factory()->createOne();
    $feature = Tithe::featureModel()::factory()->consumable()->createOne();
    $feature->plans()->attach($plan, [
        'charges' => $charges,
    ]);

    $subscriber = Team::factory()->createOne();
    $subscriber->subscribeTo($plan);

    Tithe::featureConsumptionModel()::factory()
        ->for($feature)
        ->for($subscriber, 'subscriber')
        ->createOne([
            'consumption' => $this->faker->numberBetween(5, 10),
            'expired_at' => now()->subDay(),
        ]);

    $modelCanUse = $subscriber->canConsume($feature->name, $consumption);

    $this->assertTrue($modelCanUse);
});

test('subscriber has subscription renewals', function () {
    $subscriber = Team::factory()->createOne();
    $subscription = Tithe::subscriptionModel()::factory()
        ->for($subscriber, 'subscriber')
        ->createOne();

    $renewalsCount = $this->faker->randomDigitNotNull();
    $renewals = Tithe::subscriptionRenewalModel()::factory()
        ->times($renewalsCount)
        ->for($subscription)
        ->createOne();

    $this->assertEqualsCanonicalizing(
        $renewals->pluck('id'),
        $subscriber->renewals->pluck('id'),
    );
});

test('subscriber model caches features', function () {
    $charges = $this->faker->numberBetween(5, 10);
    $consumption = $this->faker->numberBetween(1, $charges);

    $plan = Tithe::planModel()::factory()->createOne();
    $feature = Tithe::featureModel()::factory()->consumable()->createOne();
    $feature->plans()->attach($plan, [
        'charges' => $charges,
    ]);

    $subscriber = Team::factory()->createOne();
    $subscriber->subscribeTo($plan);

    $this->whileCountingQueries(fn () => $subscriber->features);
    $initiallyPerformedQueries = $this->getQueryCount();

    $this->whileCountingQueries(fn () => $subscriber->features);
    $totalPerformedQueries = $this->getQueryCount();

    $this->assertEquals($initiallyPerformedQueries, $totalPerformedQueries);
});

test('feature model has tickets', function () {
    $feature = Tithe::featureModel()::factory()->consumable()->createOne();

    $subscriber = Team::factory()->createOne();

    $ticket = $subscriber->featureTickets()->make(['expired_at' => now()->addDay()]);
    $ticket->feature()->associate($feature);
    $ticket->save();

    Tithe::supportsFeatureTicketing();

    $this->assertSame(
        $ticket->id,
        $subscriber->featureTickets->first()->id,
    );
});

test('feature model only returns tickets that are not expired', function () {
    $feature = Tithe::featureModel()::factory()->consumable()->createOne();

    $subscriber = Team::factory()->createOne();

    $expiredTicket = $subscriber->featureTickets()->make([
        'expired_at' => now()->subDay(),
    ]);

    $expiredTicket->feature()->associate($feature);
    $expiredTicket->save();

    $activeTicket = $subscriber->featureTickets()->make([
        'expired_at' => now()->addDay(),
    ]);

    $activeTicket->feature()->associate($feature);
    $activeTicket->save();

    Tithe::supportsFeatureTicketing();

    $this->assertContains(
        $activeTicket->id,
        $subscriber->featureTickets->pluck('id'),
    );

    $this->assertNotContains(
        $expiredTicket->id,
        $subscriber->featureTickets->pluck('id'),
    );
});

test('subscriber can consume additional features from tickets', function () {
    $feature = Tithe::featureModel()::factory()->consumable()->createOne();

    $subscriber = Team::factory()->createOne();

    $ticket = $subscriber->featureTickets()->make([
        'expired_at' => now()->addDay(),
    ]);

    $ticket->feature()->associate($feature);
    $ticket->save();

    Tithe::supportsFeatureTicketing();

    $this->assertContains(
        $feature->id,
        $subscriber->features->pluck('id')->toArray(),
    );
});

test('subscriber can consume features from non-expirable tickets', function () {
    $feature = Tithe::featureModel()::factory()->consumable()->createOne();

    $subscriber = Team::factory()->createOne();

    $ticket = $subscriber->featureTickets()->make([
        'expired_at' => null,
    ]);

    $ticket->feature()->associate($feature);
    $ticket->save();

    Tithe::supportsFeatureTicketing();

    $this->assertContains(
        $feature->id,
        $subscriber->features->pluck('id')->toArray(),
    );
});

test('subscriber can consume features from tickets', function () {
    $charges = $this->faker->numberBetween(5, 10);
    $consumption = $this->faker->numberBetween(1, $charges);

    $feature = Tithe::featureModel()::factory()->consumable()->createOne();
    $subscriber = Team::factory()->createOne();

    $ticket = $subscriber->featureTickets()->make([
        'charges' => $charges,
        'expired_at' => now()->addDay(),
    ]);

    $ticket->feature()->associate($feature);
    $ticket->save();

    Tithe::supportsFeatureTicketing();

    $modelCanUse = $subscriber->canConsume($feature->name, $consumption);

    $this->assertTrue($modelCanUse);
});

test('subscriber can retrieve the total charges of a feature with tickets considered', function () {
    $subscriptionFeatureCharges = $this->faker->numberBetween(5, 10);
    $ticketFeatureCharges = $this->faker->numberBetween(5, 10);

    $feature = Tithe::featureModel()::factory()->consumable()->createOne();

    $plan = Tithe::planModel()::factory()->createOne();
    $feature->plans()->attach($plan, [
        'charges' => $subscriptionFeatureCharges,
    ]);

    $subscriber = Team::factory()->createOne();
    $subscriber->subscribeTo($plan);

    $ticket = $subscriber->featureTickets()->make([
        'charges' => $ticketFeatureCharges,
        'expired_at' => now()->addDay(),
    ]);

    $ticket->feature()->associate($feature);
    $ticket->save();

    Tithe::supportsFeatureTicketing();

    $totalCharges = $subscriber->getTotalCharges($feature->name);

    $this->assertEquals($totalCharges, $subscriptionFeatureCharges + $ticketFeatureCharges);
});

test('subscriber can have access to a non consumable feature through a ticket', function () {
    $feature = Tithe::featureModel()::factory()->notConsumable()->createOne();
    $subscriber = Team::factory()->createOne();

    $ticket = $subscriber->featureTickets()->make([
        'expired_at' => now()->addDay(),
    ]);

    $ticket->feature()->associate($feature);
    $ticket->save();

    Tithe::supportsFeatureTicketing();

    $modelCanUse = $subscriber->canConsume($feature->name);

    $this->assertTrue($modelCanUse);
});

test('subscriber can retrieve total consumptions of a feature', function () {
    $consumption = $this->faker->randomDigitNotNull();

    $plan = Tithe::planModel()::factory()->createOne();
    $feature = Tithe::featureModel()::factory()->consumable()->createOne();
    $feature->plans()->attach($plan);

    $subscriber = Team::factory()->createOne();
    $subscriber->subscribeTo($plan);
    $subscriber->featureConsumptions()
        ->make([
            'consumption' => $consumption,
            'expired_at' => now()->addDay(),
        ])
        ->feature()
        ->associate($feature)
        ->save();

    Tithe::supportsFeatureTicketing();

    $receivedConsumption = $subscriber->getCurrentConsumption($feature->name);

    $this->assertEquals($consumption, $receivedConsumption);
});

test('subscriber can retrieve remaining charges of a feature', function () {
    $charges = $this->faker->numberBetween(6, 10);
    $consumption = $this->faker->numberBetween(1, 5);

    $plan = Tithe::planModel()::factory()->createOne();
    $feature = Tithe::featureModel()::factory()->consumable()->createOne();
    $feature->plans()->attach($plan, [
        'charges' => $charges,
    ]);

    $subscriber = Team::factory()->createOne();
    $subscriber->subscribeTo($plan);
    $subscriber->featureConsumptions()
        ->make([
            'consumption' => $consumption,
            'expired_at' => now()->addDay(),
        ])
        ->feature()
        ->associate($feature)
        ->save();

    Tithe::supportsFeatureTicketing();

    $receivedRemainingCharges = $subscriber->getRemainingCharges($feature->name);

    $this->assertEquals($charges - $consumption, $receivedRemainingCharges);
});

test('subscriber cant consume charges from expired tickets', function () {
    $feature = Tithe::featureModel()::factory()->consumable()->createOne();
    $subscriber = Team::factory()->createOne();

    $plan = Tithe::planModel()::factory()->createOne();
    $subscriber->subscribeTo($plan);

    $subscriptionFeatureCharges = $this->faker->numberBetween(5, 10);
    $feature->plans()->attach($plan, [
        'charges' => $subscriptionFeatureCharges,
    ]);

    $activeTicketCharges = $this->faker->numberBetween(5, 10);
    $activeTicket = $subscriber->featureTickets()->make([
        'charges' => $activeTicketCharges,
        'expired_at' => now()->addDay(),
    ]);

    $activeTicket->feature()->associate($feature);
    $activeTicket->save();

    $expiredTicketCharges = $this->faker->numberBetween(5, 10);
    $expiredTicket = $subscriber->featureTickets()->make([
        'charges' => $expiredTicketCharges,
        'expired_at' => now()->subDay(),
    ]);

    $expiredTicket->feature()->associate($feature);
    $expiredTicket->save();

    Tithe::supportsFeatureTicketing();

    $totalCharges = $subscriber->getTotalCharges($feature->name);

    $this->assertEquals($totalCharges, $subscriptionFeatureCharges + $activeTicketCharges);
});

test('tickets can be turned of from the config', function () {
    $feature = Tithe::featureModel()::factory()->consumable()->createOne();
    $subscriber = Team::factory()->createOne();

    $plan = Tithe::planModel()::factory()->createOne();
    $plan->features()->attach($feature);
    $subscriber->subscribeTo($plan);

    $ticket = $subscriber->featureTickets()->make([
        'expired_at' => now()->addDay(),
    ]);

    $ticket->feature()->associate($feature);
    $ticket->save();

    Tithe::supportsFeatureTicketing();
    $featuresWithTickets = Team::first()->features;

    Tithe::supportsFeatureTicketing(false);
    $featuresWithoutTickets = Team::first()->features;

    $this->assertCount(2, $featuresWithTickets);
    $this->assertCount(1, $featuresWithoutTickets);
});

test('ticket can be created', function () {
    $charges = $this->faker->randomDigitNotNull();
    $expiration = $this->faker->dateTime();

    $feature = Tithe::featureModel()::factory()->consumable()->createOne();

    $subscriber = Team::factory()->createOne();

    Tithe::supportsFeatureTicketing();

    $subscriber->giveTicketFor($feature->name, $expiration, $charges);

    $this->assertDatabaseHas('feature_tickets', [
        'charges' => $charges,
        'expired_at' => $expiration,
        'subscriber_id' => $subscriber->id,
    ]);
});

test('non-expirable ticket can be created', function () {
    $charges = $this->faker->randomDigitNotNull();

    $feature = Tithe::featureModel()::factory()->consumable()->createOne();

    $subscriber = Team::factory()->createOne();

    Tithe::supportsFeatureTicketing();

    $subscriber->giveTicketFor($feature->name, null, $charges);

    $this->assertDatabaseHas('feature_tickets', [
        'charges' => $charges,
        'expired_at' => null,
        'subscriber_id' => $subscriber->id,
    ]);
});

test('creating event is fired when creating a ticket', function () {
    $charges = $this->faker->randomDigitNotNull();
    $expiration = $this->faker->dateTime();

    $feature = Tithe::featureModel()::factory()->consumable()->createOne();

    $subscriber = Team::factory()->createOne();

    Tithe::supportsFeatureTicketing();

    Event::fake();

    $subscriber->giveTicketFor($feature->name, $expiration, $charges);

    Event::assertDispatched(FeatureTicketCreated::class);
});

test('exception is thrown when creating a ticket for a non-existing feature', function () {
    $charges = $this->faker->randomDigitNotNull();
    $expiration = $this->faker->dateTime();

    $unexistingFeatureName = $this->faker->word();

    $subscriber = Team::factory()->createOne();

    $this->expectException(ModelNotFoundException::class);

    Tithe::supportsFeatureTicketing();

    $subscriber->giveTicketFor($unexistingFeatureName, $expiration, $charges);
});

test('exception is thrown when creating a ticket for a disabled feature', function () {
    $charges = $this->faker->randomDigitNotNull();
    $expiration = $this->faker->dateTime();

    $feature = Tithe::featureModel()::factory()->consumable()->createOne();

    $subscriber = Team::factory()->createOne();

    $this->expectException(LogicException::class);
    $this->expectExceptionMessage('The tickets are not enabled in the configs.');

    Tithe::supportsFeatureTicketing(false);

    $subscriber->giveTicketFor($feature->name, $expiration, $charges);
});

test('non expirable consumption can be created for quota features', function () {
    $charges = $this->faker->numberBetween(5, 10);
    $consumption = $this->faker->numberBetween(1, $charges);

    $plan = Tithe::planModel()::factory()->createOne();
    $feature = Tithe::featureModel()::factory()->quota()->createOne();
    $feature->plans()->attach($plan, [
        'charges' => $charges,
    ]);

    $subscriber = Team::factory()->createOne();
    $subscriber->subscribeTo($plan);

    $subscriber->consume($feature->name, $consumption);

    $this->assertDatabaseHas('feature_consumptions', [
        'consumption' => $consumption,
        'feature_id' => $feature->id,
        'subscriber_id' => $subscriber->id,
        'expired_at' => null,
    ]);
});

test('new consumptions are not created for quota features', function () {
    $charges = $this->faker->numberBetween(5, 10);
    $consumption = $this->faker->numberBetween(1, $charges / 2);

    $plan = Tithe::planModel()::factory()->createOne();
    $feature = Tithe::featureModel()::factory()->quota()->createOne();
    $feature->plans()->attach($plan, [
        'charges' => $charges,
    ]);

    $subscriber = Team::factory()->createOne();
    $subscriber->subscribeTo($plan);

    $subscriber->consume($feature->name, $consumption);
    $subscriber->consume($feature->name, $consumption);

    $this->assertDatabaseCount('feature_consumptions', 1);
    $this->assertDatabaseHas('feature_consumptions', [
        'consumption' => $consumption * 2,
        'feature_id' => $feature->id,
        'subscriber_id' => $subscriber->id,
        'expired_at' => null,
    ]);
});

test('consumption can be set on a quota feature', function () {
    $charges = $this->faker->numberBetween(5, 10);
    $consumption = $this->faker->numberBetween(1, $charges / 2);

    $plan = Tithe::planModel()::factory()->createOne();
    $feature = Tithe::featureModel()::factory()->quota()->createOne();
    $feature->plans()->attach($plan, [
        'charges' => $charges,
    ]);

    $subscriber = Team::factory()->createOne();
    $subscriber->subscribeTo($plan);

    $subscriber->consume($feature->name, $consumption);
    $subscriber->consume($feature->name, $consumption);
    $subscriber->setConsumedQuota($feature->name, $consumption);

    $this->assertDatabaseHas('feature_consumptions', [
        'consumption' => $consumption,
        'feature_id' => $feature->id,
        'subscriber_id' => $subscriber->id,
        'expired_at' => null,
    ]);
});

test('exception is thrown when setting consumed quota on a non-consummable feature', function () {
    $charges = $this->faker->numberBetween(5, 10);
    $consumption = $this->faker->numberBetween(1, $charges / 2);

    $plan = Tithe::planModel()::factory()->createOne();
    $feature = Tithe::featureModel()::factory()->notQuota()->createOne();
    $feature->plans()->attach($plan, [
        'charges' => $charges,
    ]);

    $subscriber = Team::factory()->createOne();
    $subscriber->subscribeTo($plan);

    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('The feature is not a quota feature.');

    $subscriber->setConsumedQuota($feature->name, $consumption);
});

test('subscriber can be checked if on a subscription with a provided plan', function () {
    $plan = Tithe::planModel()::factory()->createOne();

    $subscriber = Team::factory()->createOne();
    $subscriber->subscribeTo($plan);

    $hasSubscription = $subscriber->hasSubscriptionTo($plan);
    $isSubscribed = $subscriber->isSubscribedTo($plan);

    $this->assertTrue($hasSubscription);
    $this->assertTrue($isSubscribed);
});

test('subscriber can be checked if not on a subscription with a provided plan', function () {
    $plan = Tithe::planModel()::factory()->createOne();

    $subscriber = Team::factory()->createOne();
    $subscriber->subscribeTo($plan);

    $hasSubscription = $subscriber->missingSubscriptionTo($plan);
    $isSubscribed = $subscriber->isNotSubscribedTo($plan);

    $this->assertFalse($hasSubscription);
    $this->assertFalse($isSubscribed);
});

test('subscriber can consumer a feature even after the quota is exhausted when it is postpaid', function () {
    $charges = $this->faker->numberBetween(5, 10);
    $consumption = $this->faker->numberBetween(1, $charges * 2);

    $plan = Tithe::planModel()::factory()->createOne();
    $feature = Tithe::featureModel()::factory()->postpaid()->createOne();
    $feature->plans()->attach($plan, [
        'charges' => $charges,
    ]);

    $subscriber = Team::factory()->createOne();
    $subscriber->subscribeTo($plan);

    $subscriber->consume($feature->name, $consumption);

    $this->assertDatabaseHas('feature_consumptions', [
        'consumption' => $consumption,
        'feature_id' => $feature->id,
        'subscriber_id' => $subscriber->id,
    ]);
});

test('negative charges are not returned for features', function () {
    $charges = $this->faker->numberBetween(5, 10);
    $consumption = $this->faker->numberBetween($charges + 1, $charges * 2);

    $plan = Tithe::planModel()::factory()->createOne();
    $feature = Tithe::featureModel()::factory()->postpaid()->createOne();
    $feature->plans()->attach($plan, [
        'charges' => $charges,
    ]);

    $subscriber = Team::factory()->createOne();
    $subscriber->subscribeTo($plan);

    $subscriber->consume($feature->name, $consumption);

    $this->assertEquals(0, $subscriber->getRemainingCharges($feature->name));
});

test('negative balance is returned for features', function () {
    $charges = $this->faker->numberBetween(5, 10);
    $consumption = $this->faker->numberBetween($charges + 1, $charges * 2);

    $plan = Tithe::planModel()::factory()->createOne();
    $feature = Tithe::featureModel()::factory()->postpaid()->createOne();
    $feature->plans()->attach($plan, [
        'charges' => $charges,
    ]);

    $subscriber = Team::factory()->createOne();
    $subscriber->subscribeTo($plan);

    $subscriber->consume($feature->name, $consumption);

    $this->assertLessThan(0, $subscriber->balance($feature->name));
});

test('returns remaining charges for the provided subscriber only', function () {
    Tithe::supportsFeatureTicketing();

    $charges = $this->faker->numberBetween(5, 10);

    $feature = Tithe::featureModel()::factory()->createOne();

    $subscriber = Team::factory()->createOne();
    $subscriber->giveTicketFor($feature->name, null, $charges);

    $otherSubscriber = Team::factory()->createOne();
    $otherSubscriber->giveTicketFor($feature->name, null, $charges);

    $this->assertEquals($charges, $subscriber->getRemainingCharges($feature->name));
});
