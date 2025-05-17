<?php

namespace App\Actions\JobAd;

use App\Models\JobAd;

class GetJobAdById
{
    public function handle(int $id): JobAd
    {
        return JobAd::query()->whereId($id)->firstOrFail();
    }
}
