<?php

namespace App\Actions\JobAd;

use App\Models\JobAd;
use App\Resource\JobAd\JobAdOptionsResource;
use Illuminate\Support\Facades\Concurrency;

class GetJobAdOptions
{
    public function handle(): JobAdOptionsResource
    {
        $jobAd = JobAd::query()->make();
        [
            $department,
            $recruitingCategory,
            $employmentType,
            $seniority,
            $schedule,
            $status,
            $yearsOfExperience,
            $occupation,
            $occupationCategory,
        ] = Concurrency::run([
            fn () => JobAd::query()
                ->select('department')
                ->distinct()
                ->pluck('department')
                ->merge($jobAd->departmentOptions)
                ->unique()
                ->values()
                ->toArray(),
            fn () => JobAd::query()
                ->select('recruiting_category')
                ->distinct()
                ->pluck('recruiting_category')
                ->merge($jobAd->recruitingCategoryOptions)
                ->unique()
                ->values()
                ->toArray(),
            fn () => JobAd::query()
                ->select('employment_type')
                ->distinct()
                ->pluck('employment_type')
                ->merge($jobAd->employmentTypeOptions)
                ->unique()
                ->values()
                ->toArray(),
            fn () => JobAd::query()
                ->select('seniority')
                ->distinct()
                ->pluck('seniority')
                ->merge($jobAd->seniorityOptions)
                ->unique()
                ->values()
                ->toArray(),
            fn () => JobAd::query()
                ->select('schedule')
                ->distinct()
                ->pluck('schedule')
                ->merge($jobAd->scheduleOptions)
                ->unique()
                ->values()
                ->toArray(),
            fn () => JobAd::query()
                ->select('status')
                ->distinct()
                ->pluck('status')
                ->merge($jobAd->statusOptions)
                ->unique()
                ->values()
                ->toArray(),
            fn () => JobAd::query()
                ->select('years_of_experience')
                ->distinct()
                ->pluck('years_of_experience')
                ->merge($jobAd->yearsOfExperienceOptions)
                ->unique()
                ->values()
                ->toArray(),
            fn () => JobAd::query()
                ->select('occupation')
                ->distinct()
                ->pluck('occupation')
                ->merge($jobAd->occupationOptions)
                ->unique()
                ->values()
                ->toArray(),
            fn () => JobAd::query()
                ->select('occupation_category')
                ->distinct()
                ->pluck('occupation_category')
                ->merge($jobAd->occupationCategoryOptions)
                ->unique()
                ->values()
                ->toArray(),
        ]);

        return JobAdOptionsResource::from(
            compact(
                'department',
                'recruitingCategory',
                'employmentType',
                'seniority',
                'schedule',
                'status',
                'yearsOfExperience',
                'occupation',
                'occupationCategory'
            )
        );
    }
}
