<?php

use App\Models\User;

use function Pest\Laravel\postJson;

it('should get a new token', function () {
    $admin = User::factory()->admin()->create();
    $accessToken = postJson(route('api.auth.login'), [
        'email' => $admin->email,
        'password' => 'password',
    ])->json('accessToken');

    $response = actingAsJWT($admin)->postJson(uri: route('api.auth.refresh'));

    $response->assertCreated()
        ->assertExactJsonStructure(['accessToken'])
        ->assertJsonMissingExact(['accessToken' => $accessToken]);
});
