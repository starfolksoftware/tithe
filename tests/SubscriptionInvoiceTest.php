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
