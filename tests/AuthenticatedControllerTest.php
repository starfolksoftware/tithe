<?php

beforeAll(function () {
    setTestModels();
});

test('login page renders', function () {
    $this->get(route('tithe.login'))
            ->assertSuccessful()
            ->assertViewIs('tithe::auth.login')
            ->assertSeeText('Sign in to your account');
});
