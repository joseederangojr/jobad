<?php

namespace App\Actions\JobAd;

use App\Data\JobAd\StoreJobAdData;
use App\Models\JobAd;

class StoreJobAd
{
    public function handle(StoreJobAdData $data): JobAd
    {
        return JobAd::query()->create([
            'name' => $data->name,
            'subcompany' => $data->subcompany,
            'office' => $data->office,
            'department' => $data->department,
            'recruiting_category' => $data->recruitingCategory,
            'employment_type' => $data->employmentType,
            'seniority' => $data->seniority,
            'schedule' => $data->schedule,
            'years_of_experience' => $data->yearsOfExperience,
            'keywords' => $data->keywords,
            'occupation' => $data->occupation,
            'occupation_category' => $data->occupationCategory,
            'job_descriptions' => $data->jobDescriptions,
        ]);
    }
}
