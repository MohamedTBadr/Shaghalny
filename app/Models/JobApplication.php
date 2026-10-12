<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class JobApplication extends Model
{
    //
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'job_applications';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'status','AI_Generated_score','AI_Generated_feedback','JobVacancy_id','user_id'
        ,'resume_id'
    ];


    protected $dates = [
        'deleted_at'
    ];

    protected function casts()
    {
        return [
            'deleted_at' => 'datetime'
        ];
    }

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class, 'JobVacancy_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function resume()
    {
        return $this->belongsTo(Resume::class, 'resume_id', 'id');
    }

    public function statusHistories()
    {
        return $this->hasMany(ApplicationStatusHistory::class, 'application_id', 'id')
            ->orderBy('created_at');
    }

    public function statusText()
    {
        return match ($this->status) {
            'Accepted' => 'Accepted',
            'Rejected' => 'Rejected',
            default => 'Under review',
        };
    }
}
