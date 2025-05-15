<?php

namespace App\Resource\Auth;

use Spatie\LaravelData\Data;

class LoginResource extends Data
{
    public function __construct(
        public string $accessToken,
        public int $expiresIn
    ) {}
}
