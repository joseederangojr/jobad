<?php

namespace App\Actions\User;

use App\Models\JobAd;
use App\Models\User;
use App\Resource\JobAd\JobAdResource;
use App\Resource\Notification\NotificationResource;
use App\Resource\User\UserResource;

class GetUserNotifications
{
    public function handle(User $user)
    {
        $user->loadMissing('notifications');
        $notifications = $user
            ->notifications()
            ->get()
            ->map(function ($notif) {
                return NotificationResource::from(
                    array_merge($notif->toArray(), [
                        'job' => JobAdResource::from(
                            JobAd::query()
                                ->whereId($notif->data['job_id'])
                                ->first()
                        ),
                        'employer' => UserResource::from(
                            User::query()
                                ->whereId($notif->data['employer_id'])
                                ->first()
                        ),
                    ])
                );
            })
            ->all();

        return $notifications;
    }
}
