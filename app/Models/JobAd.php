<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin JobAd
 *
 * @property-read array<int, string> $departmentOptions
 * @property-read array<int, string> $recruitingCategoryOptions
 * @property-read array<int, string> $employmentTypeOptions
 * @property-read array<int, string> $seniorityOptions
 * @property-read array<int, string> $scheduleOptions
 * @property-read array<int, string> $statusOptions
 * @property-read array<int, string> $yearsOfExperienceOptions
 * @property-read array<int, string> $occupationOptions
 * @property-read array<int, string> $occupationCategoryOptions
 * */
class JobAd extends Model
{
    /** @use HasFactory<\Database\Factories\JobAdFactory> */
    use HasFactory;

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'keywords' => 'array',
            'job_descriptions' => 'array',
        ];
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by_id');
    }

    /**
     * Register events
     */
    public static function boot()
    {
        parent::boot(); // call so parent will not be mad
        static::creating(function (JobAd $jobAd) {
            $user = Auth::user();
            if ($user) {
                $jobAd->created_by_id = $user->id;
                $jobAd->updated_by_id = $user->id;
            }
        });

        static::updating(function (JobAd $jobAd) {
            $user = Auth::user();
            if ($user) {
                $jobAd->updated_by_id = $user->id;
            }
        });

        static::deleting(function (JobAd $jobAd) {
            $user = Auth::user();
            if ($user) {
                $jobAd->deleted_by_id = $user->id;
            }
        });
    }

    /**
     * Getters
     */
    public function getDepartmentOptionsAttribute(): array
    {
        return [
            'recruiting',
            'marketing',
            'sales',
            'engineering',
            'finance',
            'hr',
        ];
    }

    public function getRecruitingCategoryOptionsAttribute(): array
    {
        return ['marketing', 'sales', 'recruiting', 'engineering'];
    }

    public function getEmploymentTypeOptionsAttribute(): array
    {
        return [
            'parmanent',
            'part-time',
            'temporary',
            'contract',
            'freelance',
            'internship',
            'seasonal',
            'on-call',
        ];
    }

    public function getSeniorityOptionsAttribute(): array
    {
        return ['experienced', 'senior', 'middle', 'entry'];
    }

    public function getScheduleOptionsAttribute(): array
    {
        return ['full-Time', 'part-Time', 'flexible', 'fixed'];
    }

    public function getStatusOptionsAttribute(): array
    {
        return ['pending', 'approved', 'rejected'];
    }

    public function getYearsOfExperienceAttribute(): array
    {
        return ['0-1', '2-4', '5-7', '8-10', '10+'];
    }

    public function getOccupationOptionsAttribute(): array
    {
        return [
            'software engineer',
            'nurse',
            'teacher',
            'mechanic',
            'marketing manager',
            'data analyst',
            'accountant',
            'construction worker',
            'lawyer',
            'chef',
        ];
    }

    public function geOccupationCategoryAttribute(): array
    {
        return [
            'technology',
            'healthcare',
            'education',
            'skilled trades',
            'business',
            'finance',
            'construction',
            'legal',
            'hospitality',
        ];
    }
}
