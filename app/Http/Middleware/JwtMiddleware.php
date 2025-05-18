<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response()->json(
                ['error' => 'InvalidToken', 'message' => 'Invalid token'],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        return $next($request);
    }
}
