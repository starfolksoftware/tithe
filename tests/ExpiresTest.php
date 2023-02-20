<?php

use Illuminate\Foundation\Testing\WithFaker;
use Tithe\Tithe;

beforeAll(function () {
    setTestModels();
});

uses(WithFaker::class);

test('expired feature consumption models are not returned by default', function () {
    $expiredModelsCount = $this->faker()->randomDigitNotNull();
    Tithe::featureConsumptionModel()::factory()->count($expiredModelsCount)->create([
        'expired_at' => now()->subDay(),
    ]);

    $unexpiredModelsCount = $this->faker()->randomDigitNotNull();
    $unexpiredModels = Tithe::featureConsumptionModel()::factory()->count($unexpiredModelsCount)->create([
        'expired_at' => now()->addDay(),
    ]);

    $returnedSubscriptions = Tithe::featureConsumptionModel()::all();

    $this->assertEqualsCanonicalizing(
        $unexpiredModels->pluck('id')->toArray(),
        $returnedSubscriptions->pluck('id')->toArray(),
    );
});

test('expired feature consumption models are returned when applying withExpired scope', function () {
    $expiredModelsCount = $this->faker()->randomDigitNotNull();
    $expiredModels = Tithe::featureConsumptionModel()::factory()->count($expiredModelsCount)->create([
        'expired_at' => now()->subDay(),
    ]);

    $unexpiredModelsCount = $this->faker()->randomDigitNotNull();
    $unexpiredModels = Tithe::featureConsumptionModel()::factory()->count($unexpiredModelsCount)->create([
        'expired_at' => now()->addDay(),
    ]);

    $expectedSubscriptions = $expiredModels->concat($unexpiredModels);

    $returnedSubscriptions = Tithe::featureConsumptionModel()::withExpired()->get();

    $this->assertEqualsCanonicalizing(
        $expectedSubscriptions->pluck('id')->toArray(),
        $returnedSubscriptions->pluck('id')->toArray(),
    );
});

test('only expired feature consumption models are returned when applying onlyExpired scope', function () {
    $expiredModelsCount = $this->faker()->randomDigitNotNull();
    $expiredModels = Tithe::featureConsumptionModel()::factory()->count($expiredModelsCount)->create([
        'expired_at' => now()->subDay(),
    ]);

    $unexpiredModelsCount = $this->faker()->randomDigitNotNull();
    Tithe::featureConsumptionModel()::factory()->count($unexpiredModelsCount)->create([
        'expired_at' => now()->addDay(),
    ]);

    $returnedSubscriptions = Tithe::featureConsumptionModel()::onlyExpired()->get();

    $this->assertEqualsCanonicalizing(
        $expiredModels->pluck('id')->toArray(),
        $returnedSubscriptions->pluck('id')->toArray(),
    );
});

test('feature consumption model can return expired status', function () {
    $expiredModel = Tithe::featureConsumptionModel()::factory()
        ->expired()
        ->create();

    $notExpiredModel = Tithe::featureConsumptionModel()::factory()
        ->notExpired()
        ->create();

    $this->assertTrue($expiredModel->expired());
    $this->assertFalse($notExpiredModel->expired());
});

test('feature consumption model can return not expired status', function () {
    $expiredModel = Tithe::featureConsumptionModel()::factory()
        ->expired()
        ->create();

    $notExpiredModel = Tithe::featureConsumptionModel()::factory()
        ->notExpired()
        ->create();

    $this->assertFalse($expiredModel->notExpired());
    $this->assertTrue($notExpiredModel->notExpired());
});

test('feature consumptions without expiration date are returned by default', function () {
    $expiredModelsCount = $this->faker()->randomDigitNotNull();
    Tithe::featureConsumptionModel()::factory()->count($expiredModelsCount)->create([
        'expired_at' => now()->subDay(),
    ]);

    $unexpiredModelsCount = $this->faker()->randomDigitNotNull();
    $unexpiredModels = Tithe::featureConsumptionModel()::factory()->count($unexpiredModelsCount)->create([
        'expired_at' => null,
    ]);

    $returnedSubscriptions = Tithe::featureConsumptionModel()::all();

    $this->assertEqualsCanonicalizing(
        $unexpiredModels->pluck('id')->toArray(),
        $returnedSubscriptions->pluck('id')->toArray(),
    );
});
