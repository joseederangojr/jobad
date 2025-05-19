<?php

namespace App\Resource\User;

use App\Resource\Notification\NotificationResource;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

/**
 * @property-read array<int, NotificationResource> $notifications
 */
class UserResource extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $role,
        #[
            MapName('email_verified_at'),
            WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s.u\Z')
        ]
        public ?Carbon $emailVerifiedAt,

        #[
            MapName('created_at'),
            WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s.u\Z')
        ]
        public Carbon $createdAt,

        #[
            MapName('updated_at'),
            WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s.u\Z')
        ]
        public Carbon $updatedAt,

        #[
            MapName('deleted_at'),
            WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s.u\Z')
        ]
        public ?Carbon $deletedAt,

        public ?array $notifications = []
    ) {}
}
