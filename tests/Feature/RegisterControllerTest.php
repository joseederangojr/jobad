<?php

use Tests\TestCase;

it('should register user', function () {
    /** @var TestCase $this */
    $response = $this->post(route('api.auth.register'), [
        'role' => 'admin',
        'name' => 'New User',
        'email' => 'new@user.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);
    $response->assertStatus(201);
});

it('should return validation error', function () {
    /** @var TestCase $this */
    $this->makeAdminUser();
    $response = $this->post(route('api.auth.register'), [
        'role' => 'admin',
        'name' => 'Admin User',
        'email' => 'admin@user.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);
    $response->assertStatus(302);
});
