<?php

namespace App\Http\Controllers\Job;

use App\Actions\JobAd\GetJobAdById;
use App\Actions\JobAd\RejectJobAd;
use App\Data\JobAd\RejectJobAdData;
use App\Http\Controllers\Controller;
use App\Resource\JobAd\JobAdResource;

class JobAdRejectController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RejectJobAdData $data, int $id, RejectJobAd $reject, GetJobAdById $get): JobAdResource
    {
        return JobAdResource::from($reject->handle($get->handle($id)));
    }
}
