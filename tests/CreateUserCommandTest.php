<?php

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tithe\Tithe;

beforeAll(function () {
    setTestModels();
});

uses(WithFaker::class);

test('a user can be created using the command', function (string $name, string $email, string $password, string $role) {
    Artisan::call('tithe:create-user', [
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'role' => $role,
    ]);

    expect(Tithe::userModel()::count())->toBe(1);
})->with([
    ['Faruk Nasir', 'faruk@starfolksoftware.com', '12345678', 'admin'],
    ['Taylor Otwell', 'taylor@starfolksoftware.com', '12345678', 'support'],
]);
