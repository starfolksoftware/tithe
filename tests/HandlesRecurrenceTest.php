<?php

use Tithe\Tithe;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tithe\Enums\PeriodicityType;

beforeAll(function () {
    setTestModels();
});

uses(WithFaker::class);

test('plan model can calculate yearly expiration', function () {
    Carbon::setTestNow(now());

    $years = $this->faker->randomDigitNotNull();
    $plan = Tithe::planModel()::factory()->create([
        'periodicity_type' => PeriodicityType::Year,
        'periodicity' => $years,
    ]);

    $this->assertEquals(now()->addYears($years), $plan->calculateNextRecurrenceEnd());
});

test('plan model can calculate monthly expiration', function () {
    Carbon::setTestNow(now());

    $months = $this->faker->randomDigitNotNull();
    $plan = Tithe::planModel()::factory()->create([
        'periodicity_type' => PeriodicityType::Month,
        'periodicity' => $months,
    ]);

    $this->assertEquals(now()->addMonths($months), $plan->calculateNextRecurrenceEnd());
});

test('plan model can calculate weekly expiration', function () {
    Carbon::setTestNow(now());

    $weeks = $this->faker->randomDigitNotNull();
    $plan = Tithe::planModel()::factory()->create([
        'periodicity_type' => PeriodicityType::Week,
        'periodicity' => $weeks,
    ]);

    $this->assertEquals(now()->addWeeks($weeks), $plan->calculateNextRecurrenceEnd());
});

test('plan model can calculate daily expiration', function () {
    Carbon::setTestNow(now());

    $days = $this->faker->randomDigitNotNull();
    $plan = Tithe::planModel()::factory()->create([
        'periodicity_type' => PeriodicityType::Day,
        'periodicity' => $days,
    ]);

    $this->assertEquals(now()->addDays($days), $plan->calculateNextRecurrenceEnd());
});

test('plan model can calculate expiration with a different start', function () {
    Carbon::setTestNow(now());

    $weeks = $this->faker->randomDigitNotNull();
    $plan = Tithe::planModel()::factory()->create([
        'periodicity_type' => PeriodicityType::Week,
        'periodicity' => $weeks,
    ]);

    $start = now()->subDay();

    $this->assertEquals($start->copy()->addWeeks($weeks), $plan->calculateNextRecurrenceEnd($start));
});

test('plan model can calculate expiration with a different start as date time string', function () {
    Carbon::setTestNow(today());

    $weeks = $this->faker->randomDigitNotNull();
    $plan = Tithe::planModel()::factory()->create([
        'periodicity_type' => PeriodicityType::Week,
        'periodicity' => $weeks,
    ]);

    $start = today()->subDay();

    $this->assertEquals(
        $start->copy()->addWeeks($weeks),
        $plan->calculateNextRecurrenceEnd($start->toDateTimeString()),
    );
});
