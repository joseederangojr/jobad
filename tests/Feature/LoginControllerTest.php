<?php

use App\Models\User;

use function Pest\Laravel\postJson;

it('should be able to login', function () {
    $admin = User::factory()->admin()->create();

    $response = postJson(route('api.auth.login'), [
        'email' => $admin->email,
        'password' => 'password',
    ]);

    $response
        ->assertCreated() // weird behavior by laravel data package
        ->assertJsonCount(2)
        ->assertJsonStructure(['accessToken', 'expiresIn']);
});

it('should return validation error', function () {
    $admin = User::factory()->admin()->create();

    $response = postJson(route('api.auth.login'), [
        'email' => $admin->email,
        'password' => 'wrong',
    ]);

    $response->assertInvalid(['email']);
});
