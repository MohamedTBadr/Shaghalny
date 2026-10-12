<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            /* 'status','AI_Generated_score','AI_Generated_feedback','JobVacancy_id','user_id'
        ,'resume_id'*/

            $table->uuid('id')->primary();
            $table->enum('status', ['Pending', 'Accepted', 'Rejected'])->default('Pending');
            $table->float('AI_Generated_score',2)->default(0);
            $table->longText('AI_Generated_feedback')->nullable();
            $table->uuid('JobVacancy_id');
            $table->foreign('JobVacancy_id')->references('id')->on('job_vacancies')->onDelete('restrict');
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->uuid('resume_id');
            $table->foreign('resume_id')->references('id')->on('resumes')->onDelete('restrict');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
