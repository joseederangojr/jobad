<?php

namespace App\Actions\JobAd;

use App\Models\JobAd;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetJobAds
{
    public function handle(?User $user): LengthAwarePaginator
    {
        return match ($user?->role) {
            'admin' => JobAd::query()->paginate(),
            'employer' => JobAd::query()->whereCreatedById($user->id)->paginate(),
            default => JobAd::query()->whereStatus('approved')->paginate(),
        };
    }
}
