<?php

namespace App\Policies;

use App\Models\JobAd;
use App\Models\User;

class JobAdPolicy
{
    public function all(): bool
    {
        return true;
    }

    public function view(): bool
    {
        return true;
    }

    public function store(?User $user)
    {
        return $user->role === 'employer';
    }

    public function update(?User $user, JobAd $jobAd): bool
    {
        return $user?->role === 'employer' &&
            $user->id === $jobAd->created_by_id;
    }

    public function approve(?User $user): bool
    {
        return $user->role === 'admin';
    }

    public function reject(?User $user): bool
    {
        return $user->role === 'admin';
    }
}
