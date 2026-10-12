<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saved_jobs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('job_vacancy_id');
            $table->timestamps();

            $table->unique(['user_id', 'job_vacancy_id']);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('job_vacancy_id')->references('id')->on('job_vacancies')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_jobs');
    }
};