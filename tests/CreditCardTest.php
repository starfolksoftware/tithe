<?php

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\WithFaker;
use Tithe\Tests\Mocks\Team;
use Tithe\Tithe;

beforeAll(function () {
    setTestModels();
});

uses(WithFaker::class);

test('credit card model can retrieve authorizations', function () {
    $creditCard = Tithe::newCreditCardModel()::factory()->create();

    $subscriber = Team::factory()->create();

    $authorizations = Tithe::newCreditCardAuthorizationModel()::factory()
        ->for($creditCard)
        ->for($subscriber, 'subscriber')
        ->create();

    $this->assertEquals(1, $creditCard->authorizations()->count());

    $authorizations->each(function ($authorization) use ($creditCard) {
        $this->assertTrue($creditCard->authorizations->contains($authorization));
    });
});

test('a subscriber can not authorize the same card twice', function () {
    $creditCard = Tithe::newCreditCardModel()::factory()->create();

    $subscriber = Team::factory()->create();

    $this->expectException(QueryException::class);

    Tithe::newCreditCardAuthorizationModel()::factory()
        ->for($creditCard)
        ->for($subscriber, 'subscriber')
        ->count(3)
        ->create();
});

test('credit card model can detect expired card', function () {
    $creditCard = Tithe::newCreditCardModel()::factory()->create([
        'exp_month' => 12,
        'exp_year' => 2011,
    ]);

    expect($creditCard->expired())->toBeTrue();
    expect($creditCard->is_expired)->toBeTrue();
});
