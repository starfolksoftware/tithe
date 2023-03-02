<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Tithe\Tithe;

beforeAll(function () {
    setTestModels();
});

test('reset password page renders', function () {
    $this->get(route('tithe.password.reset', [
        'token' => Str::random(60),
    ]))
         ->assertSuccessful()
         ->assertViewIs('tithe::auth.passwords.reset')
         ->assertSeeText('Reset password');
});

test('tithe user password can be reset', function () {
    $user = Tithe::newUserModel()->factory()->create();

    $token = encrypt($user->id.'|'.Str::random());

    Cache::set("password.reset.{$user->id}", $token, now()->addMinutes(60));

    $this->post(route('tithe.password.update', [
        'token' => $token,
        'email' => $user->email,
        'password' => 'password',
        'password_confirmation' => 'password',
    ]))->assertRedirect(route('tithe.home'));

    $this->assertEmpty(cache()->get("password.reset.{$user->id}"));
});

test('request for new password will check for invalid email', function () {
    $user = Tithe::newUserModel()->factory()->create();
    $token = encrypt($user->id.'|'.Str::random());

    $response = $this->post(route('tithe.password.update'), [
        'token' => $token,
        'email' => 'not-an-email',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertInstanceOf(ValidationException::class, $response->exception);
});

test('request for new password will check for password confirmation', function () {
    $user = Tithe::newUserModel()->factory()->create();
    $token = encrypt($user->id.'|'.Str::random());

    $response = $this->post(route('tithe.password.update'), [
        'token' => $token,
        'email' => $user->email,
        'password' => 'password',
        'password_confirmation' => 'secret',
    ]);

    $this->assertInstanceOf(ValidationException::class, $response->exception);
});

test('request for new password will check for bad token', function () {
    $user = Tithe::newUserModel()->factory()->create();

    $this->post(route('tithe.password.update'), [
        'token' => Str::random(),
        'email' => $user->email,
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertSessionHas('invalidResetToken');
});
