<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidate_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->unique();
            $table->string('headline', 190)->nullable();
            $table->text('bio')->nullable();
            $table->string('location', 190)->nullable();
            $table->string('experience_level', 40)->nullable();
            $table->text('skills')->nullable();
            $table->text('industries')->nullable();
            $table->boolean('open_to_remote')->default(true);
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidate_profiles');
    }
};