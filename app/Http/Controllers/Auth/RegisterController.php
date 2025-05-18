<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\Register;
use App\Data\Auth\RegisterData;
use App\Http\Controllers\Controller;
use App\Resource\Auth\RegisterResource;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(
        RegisterData $registerData,
        Register $register
    ): RegisterResource {
        return $register->handle($registerData);
    }
}
