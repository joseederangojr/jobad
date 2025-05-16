<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class GetAllAdmins
{
    public function handle(): Collection
    {
        return User::query()->whereRole('admin')->get();
    }
}
