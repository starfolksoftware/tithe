<?php

use Tithe\Tithe;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tithe\Enums\PeriodicityType;

beforeAll(function () {
    setTestModels();
});

uses(WithFaker::class);

test('plan model can calculate grace days ending', function () {
    Carbon::setTestNow(now());

    $days = $this->faker->randomDigitNotNull();
    $graceDays = $this->faker->randomDigitNotNull();
    $plan = Tithe::newPlanModel()::factory()->create([
        'grace_days' => $graceDays,
        'periodicity_type' => PeriodicityType::Day,
        'periodicity' => $days,
    ]);

    $this->assertEquals(
        now()->addDays($days)->addDays($graceDays),
        $plan->calculateGraceDaysEnd($plan->calculateNextRecurrenceEnd()),
    );
});

test('plan model can retrieve its subscriptions', function () {
    $plan = Tithe::newPlanModel()::factory()
        ->create();

    $subscriptions = Tithe::newSubscriptionModel()::factory()
        ->for($plan)
        ->count($subscriptionsCount = $this->faker->randomDigitNotNull())
        ->started()
        ->notExpired()
        ->notSuppressed()
        ->create();

    $this->assertEquals($subscriptionsCount, $plan->subscriptions()->count());

    $subscriptions->each(function ($subscription) use ($plan) {
        $this->assertTrue($plan->subscriptions->contains($subscription));
    });
});
