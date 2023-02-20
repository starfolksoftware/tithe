<?php

use Illuminate\Foundation\Testing\WithFaker;
use Tithe\Tithe;

beforeAll(function () {
    setTestModels();
});

uses(WithFaker::class);

test('expired models are not returned by default', function () {
    $expiredModelsCount = $this->faker()->randomDigitNotNull();
    Tithe::featureConsumptionModel()::factory()->count($expiredModelsCount)->create([
        'expired_at' => now()->subDay(),
    ]);

    $unexpiredModelsCount = $this->faker()->randomDigitNotNull();
    $unexpiredModels = Tithe::featureConsumptionModel()::factory()->count($unexpiredModelsCount)->create([
        'expired_at' => now()->addDay(),
    ]);

    $returnedFeatureConsumptions = Tithe::featureConsumptionModel()::all();

    $this->assertEqualsCanonicalizing(
        $unexpiredModels->pluck('id')->toArray(),
        $returnedFeatureConsumptions->pluck('id')->toArray(),
    );
});

test('expired models are returned when withExpired scope is applied', function () {
    $expiredModelsCount = $this->faker()->randomDigitNotNull();
    $expiredModels = Tithe::featureConsumptionModel()::factory()->count($expiredModelsCount)->create([
        'expired_at' => now()->subDay(),
    ]);

    $unexpiredModelsCount = $this->faker()->randomDigitNotNull();
    $unexpiredModels = Tithe::featureConsumptionModel()::factory()->count($unexpiredModelsCount)->create([
        'expired_at' => now()->addDay(),
    ]);

    $expectedFeatureConsumptions = $expiredModels->concat($unexpiredModels);

    $returnedFeatureConsumptions = Tithe::featureConsumptionModel()::withExpired()->get();

    $this->assertEqualsCanonicalizing(
        $expectedFeatureConsumptions->pluck('id')->toArray(),
        $returnedFeatureConsumptions->pluck('id')->toArray(),
    );
});

test('expired models are not returned when withExpired:false scope is applied', function () {
    $expiredModelsCount = $this->faker()->randomDigitNotNull();
    Tithe::featureConsumptionModel()::factory()->count($expiredModelsCount)->create([
        'expired_at' => now()->subDay(),
    ]);

    $unexpiredModelsCount = $this->faker()->randomDigitNotNull();
    $unexpiredModels = Tithe::featureConsumptionModel()::factory()->count($unexpiredModelsCount)->create([
        'expired_at' => now()->addDay(),
    ]);

    $returnedFeatureConsumptions = Tithe::featureConsumptionModel()::withExpired(false)->get();

    $this->assertEqualsCanonicalizing(
        $unexpiredModels->pluck('id')->toArray(),
        $returnedFeatureConsumptions->pluck('id')->toArray(),
    );
});

test('only expired models are returned when onlyExpired scope is applied', function () {
    $expiredModelsCount = $this->faker()->randomDigitNotNull();
    $expiredModels = Tithe::featureConsumptionModel()::factory()->count($expiredModelsCount)->create([
        'expired_at' => now()->subDay(),
    ]);

    $unexpiredModelsCount = $this->faker()->randomDigitNotNull();
    Tithe::featureConsumptionModel()::factory()->count($unexpiredModelsCount)->create([
        'expired_at' => now()->addDay(),
    ]);

    $returnedFeatureConsumptions = Tithe::featureConsumptionModel()::onlyExpired()->get();

    $this->assertEqualsCanonicalizing(
        $expiredModels->pluck('id')->toArray(),
        $returnedFeatureConsumptions->pluck('id')->toArray(),
    );
});
