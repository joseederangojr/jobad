<?php

namespace App\Http\Controllers\User;

use App\Actions\User\ReadUserNotification;
use App\Data\User\ReadUserNotificationData;
use App\Http\Controllers\Controller;
use App\Resource\Notification\NotificationResource;
use Illuminate\Support\Facades\Auth;

class UserReadNotificationController extends Controller
{
    /**
     * @return array<int, NotificationResource>
     */
    public function __invoke(
        ReadUserNotificationData $data,
        ReadUserNotification $read
    ): array {
        return $read->handle(user: Auth::user(), data: $data);
    }
}
