<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('application_status_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('application_id');
            $table->string('status', 40);
            $table->text('note')->nullable();
            $table->string('changed_by_role', 40)->nullable();
            $table->timestamps();

            $table->index(['application_id', 'created_at']);
            $table->foreign('application_id')->references('id')->on('job_applications')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_status_histories');
    }
};