<?php

use App\Models\JobAd;
use App\Models\User;

it('should get user notifications', function () {
    $employer = User::factory()->employer()->createOne();
    $admin = User::factory()->admin()->createOne();
    $job = JobAd::factory()->makeOne();

    $jobAd = actingAsJWT($employer)->postJson(
        route('api.job-ad.store'),
        $job->toArray()
    );

    $response = actingAsJWT($admin)->getJson(
        route('api.user.notification.index')
    );

    $response
        ->assertOk()
        ->assertJsonPath('*.job.id', [$jobAd->json('id')])
        ->assertJsonPath('*.employer.id', [$employer->id])
        ->assertJsonPath('*.readAt', [null]);
});

it('should read user notifications', function () {
    $employer = User::factory()->employer()->createOne();
    $admin = User::factory()->admin()->createOne();
    $job = JobAd::factory()->makeOne();

    actingAsJWT($employer)->postJson(
        route('api.job-ad.store'),
        $job->toArray()
    );

    $response = actingAsJWT($admin)->getJson(
        route('api.user.notification.index')
    );

    $response = actingAsJWT($admin)->postJson(
        route('api.user.notification.read'),
        ['ids' => collect($response->json())->map->id]
    );
    $response->assertOk();
    expect($response->json('*.readAt'))->not->toBe([null]);
})->depends('it should get user notifications');
