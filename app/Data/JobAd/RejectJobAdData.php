<?php

namespace App\Data\JobAd;

use App\Models\JobAd;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\Data;

class RejectJobAdData extends Data
{
    public static function authorize(): bool
    {
        return Auth::user()->can('reject', JobAd::class);
    }
}
