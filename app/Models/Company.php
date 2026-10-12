<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    //
    use HasFactory,HasUuids,SoftDeletes;

    protected $table= 'companies';

    protected $keyType='string';
    public $incrementing =false;


    protected $fillable=[
        'name','address','industry','website','Owner_id'
    ];

    protected $dates=[
        'deleted_at'
    ];

    protected function casts(){
        return [
            'deleted_at'=>'datetime'
        ];
    }

    public function Owner(){
        return $this->belongsTo(User::class,'Owner_id','id');
    }

    public function jobVacancies(){
        return $this->hasMany(JobVacancy::class,'Company_id','id');
    }

    public function jobApplications(){
        return $this->hasManyThrough(JobApplication::class,JobVacancy::class,'Company_id','jobVacancy_id','id','id');
    }
}
