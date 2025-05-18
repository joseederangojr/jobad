<?php

namespace App\Resource\Auth;

use Spatie\LaravelData\Resource;

class RefreshTokenResource extends Resource
{
    public function __construct(public string $accessToken) {}
}
