<?php

namespace App\Http\Controllers\Job;

use App\Actions\JobAd\GetEmployerJobAdCount;
use App\Actions\JobAd\GetExternalJobAds;
use App\Actions\JobAd\GetJobAdById;
use App\Actions\JobAd\GetJobAds;
use App\Actions\JobAd\StoreJobAd;
use App\Data\JobAd\StoreJobAdData;
use App\Events\JobAd\FirstJobAdCreatedEvent;
use App\Http\Controllers\Controller;
use App\Resource\JobAd\JobAdResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class JobAdController extends Controller
{
    public function index(GetJobAds $jobs, GetExternalJobAds $external): JsonResponse
    {
        $user = Auth::user();
        $jobAds = $jobs->handle(Auth::user());
        if (! $user || $user->role === 'candidate') {
            $extJobAds = $external->handle();
            $mergedJobAds = $extJobAds->merge($jobAds->items());
            $jobAds = collect([])->merge($jobAds);
            $jobAds->put('data', $mergedJobAds);
            $jobAds->put('total', $jobAds->get('total') + 1);
        }

        return response()->json($jobAds);
    }

    public function show(int $id, GetJobAdById $get): JobAdResource
    {
        return JobAdResource::from($get->handle($id));
    }

    public function store(StoreJobAdData $data, StoreJobAd $store, GetEmployerJobAdCount $count): JobAdResource
    {
        $user = Auth::user();
        $jobAd = $store->handle($data);

        if ($count->handle($user->id) === 1) {
            Event::dispatch(new FirstJobAdCreatedEvent(employer: $user, job: $jobAd));
        }

        return JobAdResource::from($jobAd);

    }
}
