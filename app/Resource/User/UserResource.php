<?php

namespace App\Resource\User;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;

class UserResource extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        #[MapName('email_verified_at')]
        public ?Carbon $emailVerifiedAt,

        #[MapName('created_at')]
        public Carbon $createdAt,

        #[MapName('updated_at')]
        public Carbon $updatedAt,

        #[MapName('deleted_at')]
        public ?Carbon $deletedAt,
    ) {}
}
