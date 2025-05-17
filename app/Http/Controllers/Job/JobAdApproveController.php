<?php

namespace App\Http\Controllers\Job;

use App\Actions\JobAd\ApproveJobAd;
use App\Actions\JobAd\GetJobAdById;
use App\Data\JobAd\ApproveJobAdData;
use App\Http\Controllers\Controller;
use App\Resource\JobAd\JobAdResource;

class JobAdApproveController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ApproveJobAdData $data, ApproveJobAd $approve, GetJobAdById $get, int $id): JobAdResource
    {
        return JobAdResource::from($approve->handle($get->handle($id)));
    }
}
