<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Tithe\Mail\ResetPassword;
use Tithe\Tithe;

beforeAll(function () {
    setTestModels();
});

test('forgot password page renders', function () {
    $this->get(route('tithe.password.request'))
        ->assertSuccessful()
        ->assertViewIs('tithe::auth.passwords.email')
        ->assertSeeText('Send Password Reset Link');
});

test('request for change password link will check for an invalid email', function () {
    $response = $this->post(route('tithe.password.email'), [
        'email' => 'not-an-email',
    ]);

    $this->assertInstanceOf(ValidationException::class, $response->exception);
});

test('password reset link can be sent', function () {
    $user = Tithe::newUserModel()->factory()->create();

    Mail::fake();

    $this->post(route('tithe.password.email'), [
        'email' => $user->email,
    ])->assertRedirect(route('tithe.password.request'));

    Mail::assertSent(ResetPassword::class, function ($mail) use ($user) {
        $this->assertIsString($mail->token);

        return $mail->hasTo($user->email);
    });
});
