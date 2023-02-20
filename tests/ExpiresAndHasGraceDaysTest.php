<?php

use Illuminate\Foundation\Testing\WithFaker;
use Tithe\ExpiresAndHasGraceDays;
use Tithe\Scopes\ExpiringWithGraceDaysScope;
use Tithe\Tithe;

beforeAll(function () {
    setTestModels();
});

uses(WithFaker::class);

test('expires and has grace days trait applies scope to subscription model', function () {
    $model = Tithe::subscriptionModel()::factory()->create();

    $this->assertArrayHasKey(ExpiresAndHasGraceDays::class, class_uses_recursive($model));
    $this->assertArrayHasKey(ExpiringWithGraceDaysScope::class, $model->getGlobalScopes());
});

test('subscription model can return expired status', function () {
    $expiredModel = Tithe::subscriptionModel()::factory()->expired()->create();

    $expiredModelWithFutureGraceDays = Tithe::subscriptionModel()::factory()
        ->expired()
        ->create([
            'grace_days_ended_at' => now()->addDay(),
        ]);

    $expiredModelWithPastGraceDays = Tithe::subscriptionModel()::factory()
        ->expired()
        ->create([
            'grace_days_ended_at' => now()->subDay(),
        ]);

    $notExpiredModel = Tithe::subscriptionModel()::factory()
        ->notExpired()
        ->create();

    $this->assertTrue($expiredModel->expired());
    $this->assertFalse($expiredModelWithFutureGraceDays->expired());
    $this->assertTrue($expiredModelWithPastGraceDays->expired());
    $this->assertFalse($notExpiredModel->expired());
});

test('subscription model can return not expired status', function () {
    $expiredModel = Tithe::subscriptionModel()::factory()
        ->expired()
        ->create();

    $expiredModelWithFutureGraceDays = Tithe::subscriptionModel()::factory()
        ->expired()
        ->create([
            'grace_days_ended_at' => now()->addDay(),
        ]);

    $expiredModelWithPastGraceDays = Tithe::subscriptionModel()::factory()
        ->expired()
        ->create([
            'grace_days_ended_at' => now()->subDay(),
        ]);

    $notExpiredModel = Tithe::subscriptionModel()::factory()
        ->notExpired()
        ->create();

    $this->assertFalse($expiredModel->notExpired());
    $this->assertTrue($expiredModelWithFutureGraceDays->notExpired());
    $this->assertFalse($expiredModelWithPastGraceDays->notExpired());
    $this->assertTrue($notExpiredModel->notExpired());
});

test('if a subscription has expired', function () {
    $expiredModel = Tithe::subscriptionModel()::factory()
        ->expired()
        ->create();

    $expiredModelWithFutureGraceDays = Tithe::subscriptionModel()::factory()
        ->expired()
        ->create([
            'grace_days_ended_at' => now()->addDay(),
        ]);

    $expiredModelWithPastGraceDays = Tithe::subscriptionModel()::factory()
        ->expired()
        ->create([
            'grace_days_ended_at' => now()->subDay(),
        ]);

    $notExpiredModel = Tithe::subscriptionModel()::factory()
        ->notExpired()
        ->create();

    $this->assertTrue($expiredModel->hasExpired());
    $this->assertFalse($expiredModelWithFutureGraceDays->hasExpired());
    $this->assertTrue($expiredModelWithPastGraceDays->hasExpired());
    $this->assertFalse($notExpiredModel->hasExpired());
});

test('if a subscription has not expired', function () {
    $expiredModel = Tithe::subscriptionModel()::factory()
        ->expired()
        ->create();

    $expiredModelWithFutureGraceDays = Tithe::subscriptionModel()::factory()
        ->expired()
        ->create([
            'grace_days_ended_at' => now()->addDay(),
        ]);

    $expiredModelWithPastGraceDays = Tithe::subscriptionModel()::factory()
        ->expired()
        ->create([
            'grace_days_ended_at' => now()->subDay(),
        ]);

    $notExpiredModel = Tithe::subscriptionModel()::factory()
        ->notExpired()
        ->create();

    $this->assertFalse($expiredModel->hasNotExpired());
    $this->assertTrue($expiredModelWithFutureGraceDays->hasNotExpired());
    $this->assertFalse($expiredModelWithPastGraceDays->hasNotExpired());
    $this->assertTrue($notExpiredModel->hasNotExpired());
});
