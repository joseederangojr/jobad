<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(state: ['email' => 'admin@user.com'])
            ->admin()
            ->createOne();
        User::factory(state: ['email' => 'candidate@user.com'])
            ->candidate()
            ->createOne();
        User::factory(state: ['email' => 'employer@user.com'])
            ->employer()
            ->createOne();
    }
}
