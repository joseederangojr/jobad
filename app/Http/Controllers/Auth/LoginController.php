<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\Login;
use App\Data\Auth\LoginData;
use App\Http\Controllers\Controller;
use App\Resource\Auth\LoginResource;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginData $loginData, Login $login): LoginResource
    {

        if (! $token = $login->handle($loginData)) {
            throw ValidationException::withMessages(['email' => 'Invalid email or password.']);
        }

        return $token;
    }
}
