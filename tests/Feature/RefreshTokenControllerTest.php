<?php

use App\Models\User;

use function Pest\Laravel\postJson;

it('should get a new token', function () {
    $admin = User::factory()->admin()->create();
    $accessToken = postJson(route('api.auth.login'), [
        'email' => $admin->email,
        'password' => 'password',
    ])->json('accessToken');
    $response = postJson(uri: route('api.auth.refresh'), headers: [
        'Authorization' => "Bearer {$accessToken}",
    ]);

    expect($response->status())->toBe(201);
    expect($response->json('accessToken'))->not->toBe($accessToken);
});
