<?php

use Illuminate\Foundation\Testing\WithFaker;
use Tithe\Enums\SubscriptionInvoiceStatusEnum;
use Tithe\Tests\Mocks\Team;
use Tithe\Tithe;

beforeAll(function () {
    setTestModels();
});

uses(WithFaker::class);

test('subscription invoice model can retrieve subscription', function () {
    $subscription = Tithe::newSubscriptionModel()::factory()->create();

    $subscriber = Team::factory()->create();

    $subscriptionInvoices = Tithe::newSubscriptionInvoiceModel()::factory()
        ->for($subscription)
        ->for($subscriber, 'subscriber')
        ->count(5)
        ->create();

    $this->assertEquals(5, $subscription->subscriptionInvoices()->count());

    $subscriptionInvoices->each(function ($subscriptionInvoice) use ($subscription) {
        $this->assertTrue($subscription->subscriptionInvoices->contains($subscriptionInvoice));
    });
});

test('subscription invoice model scopes', function () {
    $subscription = Tithe::newSubscriptionModel()::factory()->create();

    $subscriber = Team::factory()->create();

    Tithe::newSubscriptionInvoiceModel()::factory()
        ->for($subscription)
        ->for($subscriber, 'subscriber')
        ->count(5)
        ->create();

    Tithe::newSubscriptionInvoiceModel()::factory()
        ->for($subscription)
        ->for($subscriber, 'subscriber')
        ->count(3)
        ->create(['due_date' => now()->subDay()]);

    Tithe::newSubscriptionInvoiceModel()::factory()
        ->for($subscription)
        ->for($subscriber, 'subscriber')
        ->count(10)
        ->create(['status' => 'paid']);

    Tithe::newSubscriptionInvoiceModel()::factory()
        ->for($subscription)
        ->for($subscriber, 'subscriber')
        ->count(2)
        ->create(['status' => 'void']);

    expect(Tithe::subscriptionInvoiceModel()::paid()->count())
        ->toBe(10);
    expect(Tithe::subscriptionInvoiceModel()::unpaid()->count())
        ->toBe(8);
    expect(Tithe::subscriptionInvoiceModel()::void()->count())
        ->toBe(2);
    expect(Tithe::subscriptionInvoiceModel()::voidOrUnpaid()->count())
        ->toBe(10);
    expect(Tithe::subscriptionInvoiceModel()::pastDue()->count())
        ->toBe(3);
});

test('subscription invoice can be marked as void, paid and unpaid', function () {
    $subscription = Tithe::newSubscriptionModel()::factory()->create();

    $subscriber = Team::factory()->create();

    [$inv1, $inv2] = Tithe::newSubscriptionInvoiceModel()::factory()
        ->for($subscription)
        ->for($subscriber, 'subscriber')
        ->count(5)
        ->create();

    $inv1->markPaid();
    expect($inv1->status)->toBe(SubscriptionInvoiceStatusEnum::PAID->value);

    $this->expectException(Exception::class);
    $this->expectExceptionMessage('A paid invoice can not be voided');
    $inv1->markVoid();

    $inv2->markVoid();
    expect($inv2->status)->toBe(SubscriptionInvoiceStatusEnum::UNPAID->value);
});
