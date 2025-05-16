<?php

namespace App\Actions\JobAd;

use App\Models\JobAd;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetEmployerJobAds
{
    public function handle(int $id): LengthAwarePaginator
    {
        return JobAd::query()->whereCreatedById($id)->paginate();
    }
}
