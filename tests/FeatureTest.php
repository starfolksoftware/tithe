<?php

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tithe\Enums\PeriodicityTypeEnum;
use Tithe\Tithe;

beforeAll(function () {
    setTestModels();
});

uses(WithFaker::class);

test('feature model can calculate yearly expiration', function () {
    Carbon::setTestNow(now());

    $years = $this->faker->randomDigitNotNull();
    $feature = Tithe::newFeatureModel()::factory()->create([
        'periodicity_type' => PeriodicityTypeEnum::YEAR->value,
        'periodicity' => $years,
    ]);

    $this->assertEquals(now()->addYears($years), $feature->calculateNextRecurrenceEnd());
});

test('feature model can calculate montly expiration', function () {
    Carbon::setTestNow(now());

    $months = $this->faker->randomDigitNotNull();
    $feature = Tithe::newFeatureModel()::factory()->create([
        'periodicity_type' => PeriodicityTypeEnum::MONTH->value,
        'periodicity' => $months,
    ]);

    $this->assertEquals(now()->addMonths($months), $feature->calculateNextRecurrenceEnd());
});

test('feature model can calculate weekly expiration', function () {
    Carbon::setTestNow(now());

    $weeks = $this->faker->randomDigitNotNull();
    $feature = Tithe::newFeatureModel()::factory()->create([
        'periodicity_type' => PeriodicityTypeEnum::WEEK->value,
        'periodicity' => $weeks,
    ]);

    $this->assertEquals(now()->addWeeks($weeks), $feature->calculateNextRecurrenceEnd());
});

test('feature model calculate daily expiration', function () {
    Carbon::setTestNow(now());

    $days = $this->faker->randomDigitNotNull();
    $feature = Tithe::newFeatureModel()::factory()->create([
        'periodicity_type' => PeriodicityTypeEnum::DAY->value,
        'periodicity' => $days,
    ]);

    $this->assertEquals(now()->addDays($days), $feature->calculateNextRecurrenceEnd());
});

test('feature model can calculate when next recurrend end based on historic recurrences', function () {
    Carbon::setTestNow(now());

    $feature = Tithe::newFeatureModel()::factory()->create([
        'periodicity_type' => PeriodicityTypeEnum::WEEK->value,
        'periodicity' => 1,
    ]);

    $startDate = now()->subDays(11);

    $this->assertEquals(now()->addDays(3), $feature->calculateNextRecurrenceEnd($startDate));
});

test('feature model is not of quota by default', function () {
    $creationPayload = Tithe::newFeatureModel()::factory()->raw();

    unset($creationPayload['quota']);

    $feature = Tithe::newFeatureModel()::create($creationPayload);

    $this->assertDatabaseHas('features', [
        'id' => $feature->id,
        'quota' => 0,
    ]);
});
