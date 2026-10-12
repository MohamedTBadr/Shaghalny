<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStatusHistory extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'application_status_histories';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'application_id',
        'status',
        'note',
        'changed_by_role',
    ];

    public function application()
    {
        return $this->belongsTo(JobApplication::class, 'application_id', 'id');
    }
}