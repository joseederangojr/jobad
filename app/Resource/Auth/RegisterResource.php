<?php

namespace App\Resource\Auth;

use Spatie\LaravelData\Resource;

class RegisterResource extends Resource
{
    public function __construct(
        public string $accessToken,
        public int $expiresIn
    ) {}
}
