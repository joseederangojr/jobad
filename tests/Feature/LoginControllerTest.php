<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

it('should be able to login', function () {
    /** @var TestCase $this */
    User::query()->create(['name' => 'Test User', 'email' => 'test@user.com', 'password' => Hash::make('password')]);
    $response = $this->post(route('api.auth.login'), [
        'email' => 'test@user.com',
        'password' => 'password',
    ]);

    $response
        ->assertStatus(200);
});

it('should return validation error', function () {
    /** @var TestCase $this */
    User::query()->create(['name' => 'Test User', 'email' => 'test@user.com', 'password' => Hash::make('password')]);
    $response = $this->post(route('api.auth.login'), [
        'email' => 'test@user.com',
        'password' => 'wrong',
    ]);

    $response
        ->assertStatus(422);
});
