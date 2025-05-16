<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Resource\Auth\RefreshTokenResource;
use Tymon\JWTAuth\Facades\JWTAuth;

class RefreshTokenController extends Controller
{
    public function __invoke(): RefreshTokenResource
    {
        return new RefreshTokenResource(accessToken: JWTAuth::refresh());
    }
}
