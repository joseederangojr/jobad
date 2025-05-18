<?php

namespace App\Data\JobAd;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;

class StoreJobAdData extends Data
{
    public function __construct(
        public string $name,
        public string $subcompany,
        public string $office,
        public string $department,
        #[MapName('recruiting_category')] public string $recruitingCategory,

        #[MapName('employment_type')] public string $employmentType,
        public string $seniority,
        public string $schedule,

        #[MapName('years_of_experience')] public string $yearsOfExperience,
        public array $keywords,
        public string $occupation,
        #[MapName('occupation_category')] public string $occupationCategory,
        #[
            DataCollectionOf(JobAdDescriptionData::class),
            MapName('job_descriptions')
        ]
        public array $jobDescriptions
    ) {}
}
