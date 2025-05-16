<?php

use App\Models\JobAd;
use App\Models\User;

use function Pest\Laravel\postJson;

it('should store job ad', function () {
    $employer = User::factory()->employer()->createOne();
    $jobAd = JobAd::factory()->owner(owner: $employer)->makeOne();
    $token = Auth::tokenById($employer->id);
    $response = postJson(route('api.job-ad.store'), $jobAd->toArray(), [
        'Authorization' => "Bearer {$token}",
    ]);
    expect($response->status())->toBe(201);
    expect($response->json('name'))->toBe($jobAd->name);
});

it('should return validation error', function () {
    $employer = User::factory()->employer()->createOne();
    $jobAd = JobAd::factory()->owner(owner: $employer)->makeOne();
    $token = Auth::tokenById($employer->id);
    $response = postJson(route('api.job-ad.store'), collect($jobAd->toArray())->except('name')->toArray(), [
        'Authorization' => "Bearer {$token}",
    ]);
    expect($response->status())->toBe(422);
    expect($response->json('errors.name'))->toBe(['The name field is required.']);
});
