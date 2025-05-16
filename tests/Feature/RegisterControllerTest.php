<?php

use function Pest\Laravel\postJson;

it('should register user', function () {
    $response = postJson(route('api.auth.register'), [
        'role' => 'admin',
        'name' => 'New User',
        'email' => 'new@user.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);
    expect($response->status())->toBe(201);
    expect($response->json())->toHaveCount(2);
    expect($response->json('accessToken'))->toBeString();
    expect($response->json('expiresIn'))->toBeInt();
});

it('should return validation error', function () {
    $admin = makeAdminUser();
    $response = postJson(route('api.auth.register'), [
        'role' => 'admin',
        'name' => 'Admin User',
        'email' => $admin->email,
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);
    expect($response->status())->toBe(422);
    expect($response->json('errors.email'))->toBe(['The email has already been taken.']);
});
