<?php

use Illuminate\Foundation\Auth\User;

test('payment method can be added', function () {
    $this->actingAs($user = User::factory()->create(), 'tithe');
});

test('payment method can be removed', function () {
    $this->actingAs($user = User::factory()->create(), 'tithe');
});
