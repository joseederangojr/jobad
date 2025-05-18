<?php

namespace App\Actions\JobAd;

use App\Resource\JobAd\JobAdResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class GetExternalJobAds
{
    /** @return Collection<JobAdResource> */
    public function handle()
    {
        $xml = $this->getXMLData();
        $json = $this->xmlToJson($xml);

        return collect([
            new JobAdResource(
                id: $json->get('id'),
                name: $json->get('name'),
                subcompany: $json->get('subcompany'),
                office: $json->get('office'),
                department: $json->get('department'),
                recruitingCategory: $json->get('recruitingCategory'),
                employmentType: $json->get('employmentType'),
                seniority: $json->get('seniority'),
                schedule: $json->get('schedule'),
                yearsOfExperience: $json->get('yearsOfExperience'),
                keywords: array_map(fn ($str) => trim($str), explode(',', $json->get('keywords'))),
                occupation: $json->get('occupation'),
                status: 'external',
                occupationCategory: $json->get('occupationCategory'),
                jobDescriptions: $json->get('jobDescriptions')['jobDescription'],
                createdAt: new Carbon($json->get('createdAt')),
                updatedAt: new Carbon($json->get('createdAt')),
                deletedAt: null,
                createdById: 0,
                updatedById: 0,
                deletedById: 0,
                createdBy: null,
                updatedBy: null,
                deletedBy: null
            ),
        ]);
    }

    private function getXMLData(): string
    {
        $response = Http::get('https://mrge-group-gmbh.jobs.personio.de/xml');

        return $response->body();
    }

    private function xmlToJson(string $xml): Collection
    {
        $xml_loaded = simplexml_load_string(data: $xml, options: LIBXML_NOCDATA);
        $json = json_encode($xml_loaded);

        return collect(collect(json_decode($json, true))->first());
    }
}
