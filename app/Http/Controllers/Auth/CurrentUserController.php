<?php

namespace App\Http\Controllers\Auth;

use App\Actions\User\GetUserNotifications;
use App\Http\Controllers\Controller;
use App\Resource\User\UserResource;
use Illuminate\Support\Facades\Auth;

class CurrentUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetUserNotifications $get): UserResource
    {
        $user = Auth::user();
        $notifications = $get->handle($user);

        return UserResource::from(
            array_merge($user->toArray(), [
                'notifications' => $notifications,
            ])
        );
    }
}
