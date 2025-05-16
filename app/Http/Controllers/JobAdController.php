<?php

namespace App\Http\Controllers;

use App\Actions\JobAd\GetEmployerJobAdCount;
use App\Actions\JobAd\StoreJobAd;
use App\Data\JobAd\StoreJobAdData;
use App\Events\JobAd\FirstJobAdCreatedEvent;
use App\Models\User;
use App\Resource\JobAd\JobAdResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class JobAdController extends Controller
{
    public function store(StoreJobAdData $data, StoreJobAd $store, GetEmployerJobAdCount $count): JobAdResource
    {
        /** @var Auth $auth */
        $auth = auth();

        /** @var User $user */
        $user = $auth->user();

        $jobAd = $store->handle($data);

        if ($count->handle($user->id) === 1) {
            Event::dispatch(new FirstJobAdCreatedEvent(employer: $user, job: $jobAd));
        }

        return JobAdResource::from($jobAd);

    }
}
