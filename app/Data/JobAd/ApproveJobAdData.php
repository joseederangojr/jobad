<?php

namespace App\Data\JobAd;

use App\Models\JobAd;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\Data;

class ApproveJobAdData extends Data
{
    public static function authorize(): bool
    {
        return Auth::user()->can('approve', JobAd::class);
    }
}
