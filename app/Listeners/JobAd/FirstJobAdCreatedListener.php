<?php

namespace App\Listeners\JobAd;

use App\Actions\JobAd\GetJobAdById;
use App\Actions\User\GetAllAdmins;
use App\Actions\User\GetUserById;
use App\Events\JobAd\FirstJobAdCreatedEvent;
use App\Notifications\JobAd\FirstJobAdCreatedNotification;
use Illuminate\Support\Facades\Notification;

class FirstJobAdCreatedListener
{
    public function __construct(private GetAllAdmins $admins) {}

    /**
     * Handle the event.
     */
    public function handle(FirstJobAdCreatedEvent $event): void
    {
        Notification::send(
            $this->admins->handle(),
            new FirstJobAdCreatedNotification(
                job: $event->job,
                employer: $event->employer,
                getUser: new GetUserById,
                getJob: new GetJobAdById
            )
        );
    }
}
