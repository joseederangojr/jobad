<?php

namespace App\Actions\JobAd;

use App\Models\JobAd;

class ApproveJobAd
{
    public function handle(JobAd $jobAd): JobAd
    {
        $jobAd->update(['status' => 'approved']);
        $jobAd->fresh();

        return $jobAd;
    }
}
