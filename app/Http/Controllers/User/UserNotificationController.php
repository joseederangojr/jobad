<?php

namespace App\Http\Controllers\User;

use App\Actions\User\GetUserNotifications;
use App\Http\Controllers\Controller;
use App\Resource\Notification\NotificationResource;
use Illuminate\Support\Facades\Auth;

class UserNotificationController extends Controller
{
    /**
     * @return array<int, NotificationResource>
     */
    public function __invoke(GetUserNotifications $get): array
    {
        return $get->handle(Auth::user());
    }
}
