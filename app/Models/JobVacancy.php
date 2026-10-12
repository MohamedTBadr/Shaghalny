<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Company;

class JobVacancy extends Model
{
    //
    use HasFactory, HasUuids, SoftDeletes;


    protected $keyType = 'string';
    public $incrementing = false;


    protected $table = 'job_vacancies';
    protected $fillable = [
        'title',
        'description',
        'location',
        'salary',
        'viewCount',
        'type',
        'Company_id',
        'Category_id',
        'status',
        'published_at',
        'expires_at',
    ];
    protected $dates = [
        'deleted_at',
        'published_at',
        'expires_at',
    ];

    protected function casts()
    {
        return [
            'deleted_at' => 'datetime',
            'published_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            });
    }

    public function isPublished(): bool
    {
        return $this->status === 'published'
            && ($this->expires_at === null || $this->expires_at->isFuture());
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public function JobCategory()
    {
        return $this->belongsTo(JobCategory::class, 'Category_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(company::class, 'Company_id', 'id');
    }
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'JobVacancy_id', 'id');
    }
}
