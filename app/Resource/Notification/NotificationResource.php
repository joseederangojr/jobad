<?php

namespace App\Resource\Notification;

use App\Resource\JobAd\JobAdResource;
use App\Resource\User\UserResource;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Resource;

class NotificationResource extends Resource
{
    public function __construct(
        public string $id,
        public string $type,
        #[MapInputName('notifiable_type')] public string $notifiableType,

        #[MapInputName('notifiable_id')] public string $notifiableId,

        #[MapInputName('job')] public JobAdResource $job,
        public UserResource $employer,

        #[
            MapInputName('read_at'),
            WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s.u\Z')
        ]
        public ?Carbon $readAt,

        #[
            MapInputName('updated_at'),
            WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s.u\Z')
        ]
        public ?Carbon $createdAt,

        #[
            MapInputName('updated_at'),
            WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d\TH:i:s.u\Z')
        ]
        public ?Carbon $updatedAt
    ) {}
}
