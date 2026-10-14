<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasUuids,Notifiable,SoftDeletes;

    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'provider',
        'provider_id',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'deleted_at' => 'datetime',
        ];
    }

    public function resumes()
    {
        return $this->hasMany(Resume::class, 'user_id', 'id');
    }

    public function savedJobs()
    {
        return $this->hasMany(SavedJob::class, 'user_id', 'id');
    }

    public function candidateProfile()
    {
        return $this->hasOne(CandidateProfile::class, 'user_id', 'id');
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'user_id', 'id');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'Owner_id', 'id');
    }
}
