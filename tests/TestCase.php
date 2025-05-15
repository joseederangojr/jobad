<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    public function makeAdminUser(): void
    {
        User::query()->create([
            'name' => 'Admin User',
            'email' => 'admin@user.com',
            'password' => Hash::make('password'),
        ]);
    }

    public function makeCandidateUser(): void
    {
        User::query()->create([
            'name' => 'Candidate User',
            'email' => 'candidate@user.com',
            'password' => Hash::make('password'),
        ]);
    }

    public function makeEmployerUser(): void
    {
        User::query()->create([
            'name' => 'Employer User',
            'email' => 'employer@user.com',
            'password' => Hash::make('password'),
        ]);
    }
}
