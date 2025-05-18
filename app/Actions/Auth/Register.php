<?php

namespace App\Actions\Auth;

use App\Data\Auth\RegisterData;
use App\Models\User;
use App\Resource\Auth\RegisterResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Register
{
    public function handle(RegisterData $registerData): ?RegisterResource
    {
        /** @var Auth $auth */
        $auth = auth();
        $user = User::query()->create([
            'name' => $registerData->name,
            'email' => $registerData->email,
            'password' => Hash::make($registerData->password),
            'role' => $registerData->role,
        ]);
        $token = $auth->tokenById($user->id);

        return new RegisterResource(
            accessToken: $token,
            expiresIn: $auth->factory()->getTTL() * 60
        );
    }
}
