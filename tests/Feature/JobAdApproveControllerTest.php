<?php

use App\Models\JobAd;
use App\Models\User;

it('should approve by admin', function () {
    $employer = User::factory()->employer()->createOne();
    $admin = User::factory()->admin()->createOne();
    $jobAd = JobAd::factory(10)->owner(owner: $employer)->create();

    $response = actingAsJWT($admin)->patchJson(route('api.job-ad.approve', ['id' => $jobAd->first()->id]));

    $response
        ->assertOk()
        ->assertJsonPath('status', 'approve');
});

it('should not be able to approve by employer', function () {
    $employer = User::factory()->employer()->createOne();
    $jobAd = JobAd::factory()->owner(owner: $employer)->createOne();

    $response = actingAsJWT($employer)->patchJson(route('api.job-ad.approve', ['id' => $jobAd->id]));

    $response
        ->assertForbidden();
});
