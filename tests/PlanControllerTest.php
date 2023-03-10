<?php

use Tithe\Tests\Mocks\TitheUser;

test('plans index page can be rendered', function () {
    $this->actingAs($user = TitheUser::factory()->create(), 'tithe');

    $response = $this->get(route('plans.index'));

    $response->assertStatus(200);
});

test('only loggedin users can see the plans index page', function () {
    $response = $this->get(route('plans.index'));

    $response->assertStatus(302);
});
