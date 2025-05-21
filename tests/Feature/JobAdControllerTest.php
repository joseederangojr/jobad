<?php

use App\Actions\JobAd\GetExternalJobAds;
use App\Events\JobAd\FirstJobAdCreatedEvent;
use App\Listeners\JobAd\FirstJobAdCreatedListener;
use App\Models\JobAd;
use App\Models\User;
use App\Notifications\JobAd\FirstJobAdCreatedNotification;
use App\Resource\JobAd\JobAdResource;

use function Pest\Laravel\getJson;
use function Pest\Laravel\spy;

it('should store job ad', function () {
    Event::fake([FirstJobAdCreatedEvent::class]);
    $employer = User::factory()->employer()->createOne();
    $jobAd = JobAd::factory()->owner(owner: $employer)->makeOne();

    $response = actingAsJWT($employer)->postJson(
        route('api.job-ad.store'),
        $jobAd->toArray()
    );

    $response->assertCreated()->assertJsonPath('name', $jobAd->name);
    Event::assertListening(
        FirstJobAdCreatedEvent::class,
        FirstJobAdCreatedListener::class
    );
});

it('should store job ad with notification', function () {
    Notification::fake([FirstJobAdCreatedNotification::class]);
    $employer = User::factory()->employer()->createOne();
    $admin = User::factory()->admin()->createOne();
    $jobAd = JobAd::factory()->owner(owner: $employer)->makeOne();

    $response = actingAsJWT($employer)->postJson(
        route('api.job-ad.store'),
        $jobAd->toArray()
    );

    $response->assertCreated()->assertJsonPath('name', $jobAd->name);
    Notification::assertSentTo($admin, FirstJobAdCreatedNotification::class);
})->depends('it should store job ad');

it('should return validation error', function () {
    $employer = User::factory()->employer()->createOne();
    $jobAd = JobAd::factory()->owner(owner: $employer)->makeOne();

    $response = actingAsJWT($employer)->postJson(
        route('api.job-ad.store'),
        collect($jobAd->toArray())->except('name')->toArray()
    );

    $response->assertInvalid(['name']);
});

it('should only get employer job ads', function () {
    $employer = User::factory()->employer()->createOne();
    JobAd::factory()
        ->owner(owner: $employer)
        ->status('approved')
        ->createMany(3);

    $response = actingAsJWT($employer)->getJson(uri: route('api.job-ad.index'));

    $response
        ->assertOk()
        ->assertJsonPath('total', 3)
        ->assertJsonPath('data.*.created_by_id', [
            $employer->id,
            $employer->id,
            $employer->id,
        ]);
});

it('should get items for job ad for candidate including external', function () {
    $mock = spy(GetExternalJobAds::class);
    $candidate = User::factory()->candidate()->createOne();
    $employer = User::factory()->employer()->createOne();
    $external = JobAdResource::from(
        JobAd::factory(state: ['id' => 6])
            ->status('external')
            ->owner(owner: $employer)
            ->make()
    );
    $mock->expects('handle')->andReturn(collect([$external]));
    JobAd::factory()
        ->owner(owner: $employer)
        ->status('approved')
        ->createMany(3);
    JobAd::factory()->owner(owner: $employer)->status('pending')->createMany(2);

    $response = actingAsJWT($candidate)->getJson(
        uri: route('api.job-ad.index')
    );

    $response->assertOk()->assertJsonPath('total', 4);
});

it('should get all items for job ad for admins', function () {
    $admin = User::factory()->admin()->createOne();
    $employer = User::factory()->employer()->createOne();
    JobAd::factory()
        ->owner(owner: $employer)
        ->status('approved')
        ->createMany(3);
    JobAd::factory()->owner(owner: $employer)->status('pending')->createMany(2);

    $response = actingAsJWT($admin)->getJson(uri: route('api.job-ad.index'));

    $response->assertOk()->assertJsonPath('total', 5);
});

it('should show job ad', function () {
    $employer = User::factory()->employer()->createOne();
    $jobAd = JobAd::factory()
        ->owner(owner: $employer)
        ->status('approved')
        ->createOne();
    JobAd::factory()->owner(owner: $employer)->status('pending')->createMany(2);

    $response = getJson(route('api.job-ad.show', ['id' => $jobAd->id]));

    $response->assertOk()->assertJson(JobAdResource::from($jobAd)->toArray());
});
