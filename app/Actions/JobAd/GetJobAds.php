<?php

namespace App\Actions\JobAd;

use App\Data\JobAd\GetJobAdsFilter;
use App\Models\JobAd;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class GetJobAds
{
    public function handle(
        ?User $user,
        GetJobAdsFilter $filter
    ): LengthAwarePaginator {
        return match ($user?->role) {
            'admin' => $this->query($filter)->paginate(),
            'employer' => $this->query($filter)
                ->whereCreatedById($user->id)
                ->paginate(),
            default => $this->query($filter)
                ->whereStatus('approved')
                ->paginate(),
        };
    }

    private function query(GetJobAdsFilter $filter): Builder
    {
        return JobAd::query()
            ->when(
                $filter->seniority,
                fn (Builder $qb, array $seniorities) => $qb->whereIn(
                    'seniority',
                    $seniorities
                )
            )
            ->when(
                $filter->department,
                fn (Builder $qb, array $departments) => $qb->whereIn(
                    'department',
                    $departments
                )
            )
            ->when(
                $filter->search,
                fn (Builder $qb, string $search) => $qb
                    ->whereLike('name', "%$search%")
                    ->orWhereLike('subcompany', "%$search%")
                    ->orWhereJsonContains('keywords', $search)
            )
            ->when(
                $filter->location,
                fn (Builder $qb, string $location) => $qb->whereLike(
                    'office',
                    "%$location%"
                )
            );
    }
}
