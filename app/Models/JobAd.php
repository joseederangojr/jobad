<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/** @mixin JobAd */
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

    public function getRouteKeyName(): string
    {
        return 'id';
    }
}
