<?php

namespace App\Actions\User;

use App\Data\User\ReadUserNotificationData;
use App\Models\User;
use App\Resource\Notification\NotificationResource;

class ReadUserNotification
{
    public function __construct(private GetUserNotifications $get) {}

    /**
     * @return array<int, NotificationResource>
     */
    public function handle(User $user, ReadUserNotificationData $data): array
    {
        $user
            ->notifications()
            ->whereIn('id', $data->ids)
            ->update(['read_at' => now()]);

        return $this->get->handle($user);
    }
}
