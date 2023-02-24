<?php

use Illuminate\Foundation\Testing\WithFaker;
use Tithe\Tithe;

beforeAll(function () {
    setTestModels();
});

uses(WithFaker::class);

test('subscription model is started when start date is in the past', function () {
    $model = Tithe::subscriptionModel()::factory()->make([
        'started_at' => now()->subDay(),
    ]);

    $this->assertTrue($model->started());
    $this->assertFalse($model->notStarted());
});

test('subscription model is not started when start date is in the future', function () {
    $model = Tithe::subscriptionModel()::factory()->make([
        'started_at' => now()->addDay(),
    ]);

    $this->assertFalse($model->started());
    $this->assertTrue($model->notStarted());
});

test('subscription model returns not started when start date is null', function () {
    $model = Tithe::subscriptionModel()::factory()->make();
    $model->started_at = null;

    $this->assertFalse($model->started());
    $this->assertTrue($model->notStarted());
});
