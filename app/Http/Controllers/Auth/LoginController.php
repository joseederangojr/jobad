<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\Login;
use App\Data\Auth\LoginData;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginData $loginData, Login $login): JsonResponse
    {

        if (! $token = $login->handle($loginData)) {
            return response()->json(ValidationException::withMessages(['email' => 'Invalid email or password']), JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json($token->toArray(), JsonResponse::HTTP_OK);
    }
}
