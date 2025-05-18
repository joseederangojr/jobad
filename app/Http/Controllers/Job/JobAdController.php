<?php

namespace App\Http\Controllers\Job;

use App\Actions\JobAd\GetEmployerJobAdCount;
use App\Actions\JobAd\GetExternalJobAds;
use App\Actions\JobAd\GetJobAdById;
use App\Actions\JobAd\GetJobAds;
use App\Actions\JobAd\StoreJobAd;
use App\Data\JobAd\GetJobAdsFilter;
use App\Data\JobAd\StoreJobAdData;
use App\Events\JobAd\FirstJobAdCreatedEvent;
use App\Http\Controllers\Controller;
use App\Resource\JobAd\JobAdResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;

class JobAdController extends Controller
{
    public function index(
        Request $request,
        GetJobAds $jobs,
        GetExternalJobAds $external
    ): JsonResponse {
        $user = Auth::user();
        $department = collect($request->input('department', []))->all();
        $seniority = collect($request->input('seniority', []))->all();
        $search = $request->input('search', '');
        $location = $request->input('location', '');
        $filter = GetJobAdsFilter::from(
            compact('department', 'seniority', 'search', 'location')
        );
        $jobAds = $jobs->handle(user: Auth::user(), filter: $filter);
        if (! $user || $user->role === 'candidate') {
            $extJobAds = Cache::remember(
                json_encode(
                    array_merge(['data' => 'external'], $filter->toArray())
                ),
                120,
                fn () => $external->handle(filter: $filter)
            );
            $mergedJobAds = $extJobAds->merge($jobAds->items());
            $jobAds = collect([])->merge($jobAds);
            $jobAds->put('data', $mergedJobAds);
            $jobAds->put('total', $jobAds->get('total') + $extJobAds->count());
        }

        return response()->json($jobAds);
    }

    public function show(int $id, GetJobAdById $get): JobAdResource
    {
        return JobAdResource::from($get->handle($id));
    }

    public function store(
        StoreJobAdData $data,
        StoreJobAd $store,
        GetEmployerJobAdCount $count
    ): JobAdResource {
        $user = Auth::user();
        $jobAd = $store->handle($data);

        if ($count->handle($user->id) === 1) {
            Event::dispatch(
                new FirstJobAdCreatedEvent(employer: $user, job: $jobAd)
            );
        }

        return JobAdResource::from($jobAd);
    }
}
