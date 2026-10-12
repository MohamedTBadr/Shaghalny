<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add publishing lifecycle fields to job vacancies.
     */
    public function up(): void
    {
        Schema::table('job_vacancies', function (Blueprint $table) {
            $table->string('status')->default('published')->index()->after('Category_id');
            $table->timestamp('published_at')->nullable()->after('status');
            $table->timestamp('expires_at')->nullable()->after('published_at');
        });

        \DB::table('job_vacancies')->whereNull('deleted_at')->update([
            'status' => 'published',
            'published_at' => \DB::raw('updated_at'),
        ]);
    }

    public function down(): void
    {
        Schema::table('job_vacancies', function (Blueprint $table) {
            $table->dropColumn(['status', 'published_at', 'expires_at']);
        });
    }
};