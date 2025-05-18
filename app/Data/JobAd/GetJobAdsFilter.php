<?php

namespace App\Data\JobAd;

use Spatie\LaravelData\Data;

class GetJobAdsFilter extends Data
{
    /**
     * @param  array<int,string>  $department
     * @param  array<int,string>  $seniority
     */
    public function __construct(
        public ?string $search = '',
        public ?string $location = '',
        public array $department = [],
        public array $seniority = []
    ) {}
}
