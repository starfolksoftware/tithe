<?php

use Illuminate\Foundation\Testing\WithFaker;
use Tithe\Tithe;

beforeAll(function () {
    setTestModels();
});

uses(WithFaker::class);

test('expired models are not returned by default', function () {
    $expiredModelsCount = $this->faker()->randomDigitNotNull();
    Tithe::subscriptionModel()::factory()->count($expiredModelsCount)->create([
        'expired_at' => now()->subDay(),
    ]);

    $unexpiredModelsCount = $this->faker()->randomDigitNotNull();
    $unexpiredModels = Tithe::subscriptionModel()::factory()->count($unexpiredModelsCount)->create([
        'expired_at' => now()->addDay(),
    ]);

    $returnedSubscriptions = Tithe::subscriptionModel()::all();

    $this->assertEqualsCanonicalizing(
        $unexpiredModels->pluck('id')->toArray(),
        $returnedSubscriptions->pluck('id')->toArray(),
    );
});

test('expired models with grace days are returned by default', function () {
    $expiredModelsWithoutGraceDaysCount = $this->faker()->randomDigitNotNull();
    Tithe::subscriptionModel()::factory()->count($expiredModelsWithoutGraceDaysCount)->create([
        'expired_at' => now()->subDay(),
        'grace_days_ended_at' => null,
    ]);

    $expiredModelsWithPastGraceDaysCount = $this->faker()->randomDigitNotNull();
    Tithe::subscriptionModel()::factory()->count($expiredModelsWithPastGraceDaysCount)->create([
        'expired_at' => now()->subDay(),
        'grace_days_ended_at' => now()->subDay(),
    ]);

    $expiredModelsWithFutureGraceDaysCount = $this->faker()->randomDigitNotNull();
    $expiredModelsWithFutureGraceDays = Tithe::subscriptionModel()::factory()
        ->count($expiredModelsWithFutureGraceDaysCount)->create([
            'expired_at' => now()->subDay(),
            'grace_days_ended_at' => now()->addDay(),
        ]);

    $returnedSubscriptions = Tithe::subscriptionModel()::all();

    $this->assertEqualsCanonicalizing(
        $expiredModelsWithFutureGraceDays->pluck('id'),
        $returnedSubscriptions->pluck('id'),
    );
});

test('expired models are returned when withExpired scope is applied', function () {
    $expiredModelsCount = $this->faker()->randomDigitNotNull();
    $expiredModels = Tithe::subscriptionModel()::factory()->count($expiredModelsCount)->create([
        'expired_at' => now()->subDay(),
    ]);

    $unexpiredModelsCount = $this->faker()->randomDigitNotNull();
    $unexpiredModels = Tithe::subscriptionModel()::factory()->count($unexpiredModelsCount)->create([
        'expired_at' => now()->addDay(),
    ]);

    $expiredModelsWithFutureGraceDays = Tithe::subscriptionModel()::factory()
        ->count($this->faker()->randomDigitNotNull())
        ->create([
            'expired_at' => now()->subDay(),
            'grace_days_ended_at' => now()->addDay(),
        ]);

    $expectedSubscriptions = $expiredModels->concat($unexpiredModels)
        ->concat($expiredModelsWithFutureGraceDays);

    $returnedSubscriptions = Tithe::subscriptionModel()::withExpired()->get();

    $this->assertEqualsCanonicalizing(
        $expectedSubscriptions->pluck('id')->toArray(),
        $returnedSubscriptions->pluck('id')->toArray(),
    );
});

test('expired models are not returned when withExpired:false is applied', function () {
    $expiredModelsCount = $this->faker()->randomDigitNotNull();
    Tithe::subscriptionModel()::factory()->count($expiredModelsCount)->create([
        'expired_at' => now()->subDay(),
    ]);

    $unexpiredModelsCount = $this->faker()->randomDigitNotNull();
    $unexpiredModels = Tithe::subscriptionModel()::factory()->count($unexpiredModelsCount)->create([
        'expired_at' => now()->addDay(),
    ]);

    $expiredModelsWithFutureGraceDays = Tithe::subscriptionModel()::factory()
        ->count($this->faker()->randomDigitNotNull())
        ->create([
            'expired_at' => now()->subDay(),
            'grace_days_ended_at' => now()->addDay(),
        ]);

    $expectedSubscriptions = $unexpiredModels->concat($expiredModelsWithFutureGraceDays);

    $returnedSubscriptions = Tithe::subscriptionModel()::withExpired(false)->get();

    $this->assertEqualsCanonicalizing(
        $expectedSubscriptions->pluck('id')->toArray(),
        $returnedSubscriptions->pluck('id')->toArray(),
    );
});

test('only expired models are returned when onlyExpired scope is applied', function () {
    $expiredModelsCount = $this->faker()->randomDigitNotNull();
    $expiredModels = Tithe::subscriptionModel()::factory()->count($expiredModelsCount)->create([
        'expired_at' => now()->subDay(),
    ]);

    $unexpiredModelsCount = $this->faker()->randomDigitNotNull();
    Tithe::subscriptionModel()::factory()->count($unexpiredModelsCount)->create([
        'expired_at' => now()->addDay(),
    ]);

    $expiredModelsWithPastGraceDays = Tithe::subscriptionModel()::factory()
        ->count($this->faker()->randomDigitNotNull())
        ->create([
            'expired_at' => now()->subDay(),
            'grace_days_ended_at' => now()->subDay(),
        ]);

    $expiredModelsWithNullGraceDays = Tithe::subscriptionModel()::factory()
        ->count($this->faker()->randomDigitNotNull())
        ->create([
            'expired_at' => now()->subDay(),
            'grace_days_ended_at' => null,
        ]);

    $expectedSubscriptions = $expiredModels->concat($expiredModelsWithNullGraceDays)
        ->concat($expiredModelsWithPastGraceDays);

    $returnedSubscriptions = Tithe::subscriptionModel()::onlyExpired()->get();

    $this->assertEqualsCanonicalizing(
        $expectedSubscriptions->pluck('id')->toArray(),
        $returnedSubscriptions->pluck('id')->toArray(),
    );
});
