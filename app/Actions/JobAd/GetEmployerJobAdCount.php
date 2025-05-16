<?php

namespace App\Actions\JobAd;

use App\Models\JobAd;

class GetEmployerJobAdCount
{
    public function handle(int $id): int
    {
        return JobAd::query()->whereCreatedById($id)->count();
    }
}
