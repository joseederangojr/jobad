<?php

namespace Database\Seeders;

use App\Models\JobAd;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobAdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employer = User::query()->whereRole('employer')->firstOrFail();
        JobAd::factory()->status('pending')->owner(owner: $employer)->createMany(1);
        JobAd::factory()->status('approved')->owner(owner: $employer)->createMany(4);
        JobAd::factory()->status('rejected')->owner(owner: $employer)->createMany(2);
    }
}
