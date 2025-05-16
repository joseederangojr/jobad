<?php

use App\Actions\JobAd\GetExternalJobAds;
use App\Models\JobAd;
use App\Models\User;
use App\Resource\JobAd\JobAdResource;

use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\spy;

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

it('should only get employer job ads', function () {
    $employer = User::factory()->employer()->createOne();
    JobAd::factory()->owner(owner: $employer)->status('approved')->createMany(3);
    $token = Auth::tokenById($employer->id);
    $response = getJson(uri: route('api.job-ad.index'), headers: [
        'Authorization' => "Bearer {$token}",
    ]);
    expect($response->status())->toBe(200);
    expect($response->json('total'))->toBe(3);
    expect($response->json('data.*.created_by_id'))->toBe([$employer->id, $employer->id, $employer->id]);
});

it('should get items for job ad for candidate including external', function () {
    $mock = spy(GetExternalJobAds::class);
    $candidate = User::factory()->candidate()->createOne();
    $employer = User::factory()->employer()->createOne();
    $external = JobAdResource::from(JobAd::factory(state: ['id' => 6])->status('external')->owner(owner: $employer)->make());
    $mock->expects('handle')->andReturn(collect([$external]));
    JobAd::factory()->owner(owner: $employer)->status('approved')->createMany(3);
    JobAd::factory()->owner(owner: $employer)->status('pending')->createMany(2);
    $token = Auth::tokenById($candidate->id);
    $response = getJson(uri: route('api.job-ad.index'), headers: [
        'Authorization' => "Bearer {$token}",
    ]);
    expect($response->status())->toBe(200);
    expect($response->json('total'))->toBe(4);
});

it('should get all items for job ad for admins', function () {
    $admin = User::factory()->admin()->createOne();
    $employer = User::factory()->employer()->createOne();
    JobAd::factory()->owner(owner: $employer)->status('approved')->createMany(3);
    JobAd::factory()->owner(owner: $employer)->status('pending')->createMany(2);
    $token = Auth::tokenById($admin->id);
    $response = getJson(uri: route('api.job-ad.index'), headers: [
        'Authorization' => "Bearer {$token}",
    ]);
    expect($response->status())->toBe(200);
    expect($response->json('total'))->toBe(5);
});
