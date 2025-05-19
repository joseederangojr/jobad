<?php

namespace App\Resource\JobAd;

use Spatie\LaravelData\Data;

class JobAdOptionsResource extends Data
{
    public function __construct(
        public array $department = [],
        public array $recruitingCategory = [],
        public array $employmentType = [],
        public array $seniority = [],
        public array $schedule = [],
        public array $status = [],
        public array $yearsOfExperience = [],
        public array $occupation = [],
        public array $occupationCategory = []
    ) {}
}
