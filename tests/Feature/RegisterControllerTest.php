<?php

use App\Models\User;

use function Pest\Laravel\postJson;

it('should register user', function () {
    $response = postJson(route('api.auth.register'), [
        'role' => 'admin',
        'name' => 'New User',
        'email' => 'new@user.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response
        ->assertCreated()
        ->assertJsonCount(2)
        ->assertJsonStructure(['accessToken', 'expiresIn']);
});

it('should return validation error', function () {
    $admin = User::factory()->admin()->create();

    $response = postJson(route('api.auth.register'), [
        'role' => 'admin',
        'name' => 'Admin User',
        'email' => $admin->email,
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertInvalid(['email']);
});
