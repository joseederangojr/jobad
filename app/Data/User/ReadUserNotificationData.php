<?php

namespace App\Data\User;

use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Data;

class ReadUserNotificationData extends Data
{
    public function __construct(
        #[Exists(table: 'notifications', column: 'id')] public array $ids
    ) {}
}
