<?php

namespace App\Http\Controllers\JobAd;

use App\Actions\JobAd\GetJobAdOptions;
use App\Http\Controllers\Controller;
use App\Resource\JobAd\JobAdOptionsResource;
use Illuminate\Http\Request;

class JobAdOptionsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetJobAdOptions $get): JobAdOptionsResource
    {
        return $get->handle();
    }
}
