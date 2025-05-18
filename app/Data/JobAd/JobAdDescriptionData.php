<?php

namespace App\Data\JobAd;

use Spatie\LaravelData\Data;

class JobAdDescriptionData extends Data
{
    public function __construct(public string $name, public string $value) {}
}
