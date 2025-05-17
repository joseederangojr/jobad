<?php

namespace App\Actions\JobAd;

use App\Models\JobAd;

class RejectJobAd
{
    public function handle(JobAd $jobAd): JobAd
    {
        $jobAd->update(['status' => 'reject']);

        return $jobAd->refresh();
    }
}
