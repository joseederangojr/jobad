<?php

namespace App\Resource\JobAd;

use App\Resource\User\UserResource;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Resource;

class JobAdResource extends Resource
{
    public function __construct(
        public int $id,
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
        #[MapName('job_descriptions')] public array $jobDescriptions,
        public ?string $status,

        public ?UserResource $createdBy,
        #[MapName('created_by_id')] public ?int $createdById,
        #[MapName('created_at')] public Carbon $createdAt,

        public ?UserResource $updatedBy,
        #[MapName('updated_by_id')] public ?int $updatedById,
        #[MapName('updated_at')] public Carbon $updatedAt,

        public ?UserResource $deletedBy,
        #[MapName('deleted_by_id')] public ?int $deletedById,
        #[MapName('deleted_at')] public ?Carbon $deletedAt
    ) {}
}
