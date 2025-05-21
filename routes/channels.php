<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel(
    'App.Models.User.{id}',
    function ($user, $id) {
        return (int) $user->id === (int) $id && $user->role === 'admin';
    },
    ['guards' => ['api']]
);
