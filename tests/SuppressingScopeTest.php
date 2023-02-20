<?php

use Tithe\Tithe;
use Illuminate\Foundation\Testing\WithFaker;

beforeAll(function () {
    setTestModels();
});

uses(WithFaker::class);

test('suppressed models are returned by default', function () {
    $suppressedModelsCount = $this->faker()->randomDigitNotNull();
    Tithe::subscriptionModel()::factory()
        ->count($suppressedModelsCount)
        ->suppressed()
        ->notExpired()
        ->started()
        ->create();

    $notSuppressedModelsCount = $this->faker()->randomDigitNotNull();
    $notSuppressedModels = Tithe::subscriptionModel()::factory()
        ->count($notSuppressedModelsCount)
        ->notSuppressed()
        ->notExpired()
        ->started()
        ->create();

    $returnedSubscriptions = Tithe::subscriptionModel()::all();

    $this->assertEqualsCanonicalizing(
        $notSuppressedModels->pluck('id')->toArray(),
        $returnedSubscriptions->pluck('id')->toArray(),
    );
});

test('suppressed models are not returned when withoutSuppressed scope is applied', function () {
    $suppressedModelsCount = $this->faker()->randomDigitNotNull();
    Tithe::subscriptionModel()::factory()
        ->count($suppressedModelsCount)
        ->suppressed()
        ->notExpired()
        ->started()
        ->create();

    $notSuppressedModelsCount = $this->faker()->randomDigitNotNull();
    $notSuppressedModels = Tithe::subscriptionModel()::factory()
        ->count($notSuppressedModelsCount)
        ->notSuppressed()
        ->notExpired()
        ->started()
        ->create();

    $returnedSubscriptions = Tithe::subscriptionModel()::withoutSuppressed()->get();

    $this->assertEqualsCanonicalizing(
        $notSuppressedModels->pluck('id')->toArray(),
        $returnedSubscriptions->pluck('id')->toArray(),
    );
});

test('suppressed models are returned when withSuppressed is called', function () {
    $suppressedModelsCount = $this->faker()->randomDigitNotNull();
    $suppressedModels = Tithe::subscriptionModel()::factory()
        ->count($suppressedModelsCount)
        ->suppressed()
        ->notExpired()
        ->started()
        ->create();

    $notSuppressedModelsCount = $this->faker()->randomDigitNotNull();
    $notSuppressedModels = Tithe::subscriptionModel()::factory()
        ->count($notSuppressedModelsCount)
        ->notSuppressed()
        ->notExpired()
        ->started()
        ->create();

    $expectedSubscriptions = $suppressedModels->concat($notSuppressedModels);

    $returnedSubscriptions = Tithe::subscriptionModel()::withSuppressed()->get();

    $this->assertEqualsCanonicalizing(
        $expectedSubscriptions->pluck('id')->toArray(),
        $returnedSubscriptions->pluck('id')->toArray(),
    );
});

test('only suppressed models are returned when onlySuppressed scope is applied', function () {
    $suppressedModelsCount = $this->faker()->randomDigitNotNull();
    $suppressedModels = Tithe::subscriptionModel()::factory()
        ->count($suppressedModelsCount)
        ->suppressed()
        ->notExpired()
        ->started()
        ->create();

    $notSuppressedModelsCount = $this->faker()->randomDigitNotNull();
    Tithe::subscriptionModel()::factory()
        ->count($notSuppressedModelsCount)
        ->notSuppressed()
        ->notExpired()
        ->started()
        ->create();

    $returnedSubscriptions = Tithe::subscriptionModel()::onlySuppressed()->get();

    $this->assertEqualsCanonicalizing(
        $suppressedModels->pluck('id')->toArray(),
        $returnedSubscriptions->pluck('id')->toArray(),
    );
});
