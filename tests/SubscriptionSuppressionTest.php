<?php

use Illuminate\Foundation\Testing\WithFaker;
use Tithe\Tithe;

beforeAll(function () {
    setTestModels();
});

uses(WithFaker::class);

test('subscription model is suppressed when suppress date is in the past', function () {
    $model = Tithe::subscriptionModel()::factory()->make([
        'suppressed_at' => now()->subDay(),
    ]);

    $this->assertTrue($model->suppressed());
    $this->assertFalse($model->notSuppressed());
});

test('subscription model is not suppressed when suppress date is in the future', function () {
    $model = Tithe::subscriptionModel()::factory()->make([
        'suppressed_at' => now()->addDay(),
    ]);

    $this->assertFalse($model->suppressed());
    $this->assertTrue($model->notSuppressed());
});

test('subscription model returns not suppressed when suppress date is null', function () {
    $model = Tithe::subscriptionModel()::factory()->make();
    $model->suppressed_at = null;

    $this->assertFalse($model->suppressed());
    $this->assertTrue($model->notSuppressed());
});
