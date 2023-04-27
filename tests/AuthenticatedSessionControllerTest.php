<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tithe\Tithe;

beforeAll(function () {
    setTestModels();
});

test('login page renders', function () {
    $this->get(route('tithe.login'))
        ->assertSuccessful()
        ->assertViewIs('tithe::auth.login')
        ->assertSeeText('Sign in to your account');
});

test('login request will check for invalid emails', function () {
    $response = $this->post(route('tithe.authenticate'), [
        'email' => 'not-an-email',
        'password' => 'password',
    ])->assertRedirect(route('tithe.login'));

    $this->assertInstanceOf(ValidationException::class, $response->exception);
});

test('login request will check for wrong passwords', function () {
    $user = Tithe::newUserModel()->factory()->create();

    $response = $this->post(route('tithe.authenticate'), [
        'email' => $user->email,
        'password' => 'what-is-my-password',
    ])->assertSessionHasErrors();

    $this->assertInstanceOf(ValidationException::class, $response->exception);
});

test('a tithe user can be successfully logged in', function () {
    $user = Tithe::newUserModel()->factory()->create([
        'password' => Hash::make('password'),
    ]);

    $this->post(route('tithe.authenticate'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('tithe.home'));
});

test('authenticated user will redirect to tithe', function () {
    $this->actingAs($user = Tithe::newUserModel()->factory()->create(), 'tithe')
        ->get(route('tithe.authenticate'))
        ->assertRedirect(route('tithe.home'));
});

test('authenticated user can successfully log out', function () {
    $this->actingAs($user = Tithe::newUserModel()->factory()->create(), 'tithe')
        ->get(route('tithe.logout'))
        ->assertRedirect(route('tithe.login'));
});
