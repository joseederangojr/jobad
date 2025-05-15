<?php

namespace App\Resource\Auth;

use Spatie\LaravelData\Data;

class RegisterResource extends Data
{
    public function __construct(
        public string $accessToken,
        public int $expiresIn
    ) {}
}
