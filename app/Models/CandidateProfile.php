<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateProfile extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'candidate_profiles';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'headline',
        'bio',
        'location',
        'experience_level',
        'skills',
        'industries',
        'open_to_remote',
        'is_available',
    ];

    protected $casts = [
        'open_to_remote' => 'boolean',
        'is_available' => 'boolean',
        'skills' => 'array',
        'industries' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}