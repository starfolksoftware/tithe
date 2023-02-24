<?php

use Illuminate\Foundation\Testing\WithFaker;
use Tithe\Tests\Mocks\Team;
use Tithe\Tithe;

beforeAll(function () {
    setTestModels();
});

uses(WithFaker::class);

test('authorization can return credit card', function () {
    $creditCard = Tithe::newCreditCardModel()::factory()->create();

    $subscriber = Team::factory()->create();

    $authorizations = Tithe::newCreditCardAuthorizationModel()::factory()
        ->for($creditCard)
        ->for($subscriber, 'subscriber')
        ->create();

    $this->assertEquals(1, $creditCard->authorizations()->count());
    expect($creditCard->authorizations()->first()->subscriber->id)
        ->toBe($subscriber->id);

    $authorizations->each(function ($authorization) use ($creditCard) {
        expect($authorization->creditCard->id)->toBe($creditCard->id);
    });
});
