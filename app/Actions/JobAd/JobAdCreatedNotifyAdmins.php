<?php

namespace App\Actions\JobAd;

use App\Models\JobAd;
use App\Models\User;
use App\Notifications\JobAd\FirstJobAdCreatedNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;

class JobAdCreatedNotifyAdmins
{
    /**
     * @var Collection<User>
     */
    public function handle(JobAd $jobAd, User $createdBy, array $admins): void
    {
        if ($createdBy->job_ads_count === 1) {
            Notification::send($admins, new FirstJobAdCreatedNotification(
                employer: $createdBy,
                job: $jobAd
            ));
        }
    }
}
