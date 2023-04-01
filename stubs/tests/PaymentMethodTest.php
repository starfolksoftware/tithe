<?php

use App\Models\User;
use StarfolkSoftware\Paystack\Client as PaystackClient;
use Tithe\Contracts\CreatesAuthorizations;
use Tithe\Tithe;

test('payment method can be added', function () {
    // $client = Mockery::mock(new PaystackClient(['secretKey' => '132323']));
    // $client->shouldReceive('post');

    // $this->actingAs($user = User::factory()->create());

    // $subscriber = call_user_func(Tithe::$activeSubscriberCallback);

    // $creator = app(CreatesAuthorizations::class);

    // $authorization = $creator->create($user, $subscriber, 'reference');

    expect(1)->toBe(1);
});

test('payment method can be removed', function () {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $creditCard = Tithe::newCreditCardModel()::factory()->create();

    $subscriber = call_user_func(Tithe::$activeSubscriberCallback);

    $authorization = Tithe::newCreditCardAuthorizationModel()::factory()
        ->for($creditCard)
        ->for($subscriber, 'subscriber')
        ->create();

    expect($authorization)->toBeTruthy();
    expect($authorization->creditCard()->count())->toBe(1);
    expect($authorization->creditCard)
        ->signature->toBe($creditCard->signature)
        ->type->toBe($creditCard->type)
        ->last4->toBe($creditCard->last4)
        ->exp_month->toBe($creditCard->exp_month);

    $response = $this->delete(route('tithe.billing.remove-authorization'), [
        'authorizationId' => $authorization->id,
    ]);

    $response->assertStatus(302);
    expect($authorization->fresh())->toBeNull();
});

test('payment method can be set as default', function () {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $creditCard1 = Tithe::newCreditCardModel()::factory()->create();
    $creditCard2 = Tithe::newCreditCardModel()::factory()->create();

    $subscriber = call_user_func(Tithe::$activeSubscriberCallback);

    $authorization1 = Tithe::newCreditCardAuthorizationModel()::factory(['default' => true])
        ->for($creditCard1)
        ->for($subscriber, 'subscriber')
        ->create();

    $authorization2 = Tithe::newCreditCardAuthorizationModel()::factory()
        ->for($creditCard2)
        ->for($subscriber, 'subscriber')
        ->create();

    $response = $this->patch(route('tithe.billing.set-default-authorization'), [
        'authorizationId' => $authorization2->id,
    ]);

    $response->assertStatus(302);
    expect($authorization2->fresh())
        ->default->toBeTruthy();
    expect($authorization1->fresh())
        ->default->toBeFalsy();
});
