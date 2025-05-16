<?php

use App\Models\User;

use function Pest\Laravel\postJson;

it('should be able to login', function () {
    $admin = User::factory()->admin()->create();
    $response = postJson(route('api.auth.login'), [
        'email' => $admin->email,
        'password' => 'password',
    ]);

    expect($response->status())->toBe(201);
    expect($response->json())->toHaveCount(2);
    expect($response->json('accessToken'))->toBeString();
    expect($response->json('expiresIn'))->toBeInt();
});

it('should return validation error', function () {
    $admin = User::factory()->admin()->create();
    $response = postJson(route('api.auth.login'), [
        'email' => $admin->email,
        'password' => 'wrong',
    ]);
    expect($response->status())->toBe(422);
    expect($response->json('errors.email'))->toBe(['Invalid email or password.']);
});
