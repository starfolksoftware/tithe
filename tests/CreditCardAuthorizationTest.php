<?php

use Illuminate\Database\QueryException;
use Tithe\Tithe;
use Illuminate\Foundation\Testing\WithFaker;
use Tithe\Tests\Mocks\Team;

beforeAll(function () {
    setTestModels();
});

uses(WithFaker::class);

test('credit card auth model can retrieve payments', function () {
    $subscriptionInvoice = Tithe::newSubscriptionInvoiceModel()::factory()->create();

    $subscriber = Team::factory()->create();

    $payments = Tithe::newSubscriptionInvoicePaymentModel()::factory()
        ->for($subscriptionInvoice)
        ->for($subscriber, 'subscriber')
        ->create();

    $this->assertEquals(1, $creditCard->payments()->count());

    $payments->each(function ($authorization) use ($creditCard) {
        $this->assertTrue($creditCard->payments->contains($authorization));
    });
});