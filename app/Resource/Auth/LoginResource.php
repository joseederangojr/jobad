<?php

namespace App\Resource\Auth;

use Spatie\LaravelData\Resource;

class LoginResource extends Resource
{
    public function __construct(
        public string $accessToken,
        public int $expiresIn
    ) {}
}
