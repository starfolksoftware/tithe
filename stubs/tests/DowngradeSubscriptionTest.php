<?php

use App\Models\User;

test('a subscription can not be downgraded from a lower priced plan to a higher priced plan', function () {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $response = $this->post(route('tithe.billing.downgrade-subscription'), ['planName' => 'enterprise-monthly']);

    $response->assertSessionHasErrors(['downgrade-error'], errorBag: 'downgradeSubscription');
});
