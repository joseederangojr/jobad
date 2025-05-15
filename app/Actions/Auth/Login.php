<?php

namespace App\Actions\Auth;

use App\Data\Auth\LoginData;
use App\Resource\Auth\LoginResource;
use Illuminate\Support\Facades\Auth;

class Login
{
    public function handle(LoginData $loginData): ?LoginResource
    {

        /** @var Auth $auth */
        $auth = auth();

        if (! $token = $auth->attempt($loginData->toArray())) {
            return null;
        }

        return new LoginResource(accessToken: $token, expiresIn: $auth->factory()->getTTL() * 60);
    }
}
