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
        Schema::create('job_vacancies', function (Blueprint $table) {
            /*'title',
        'description',
        'location',
        'salary',
        'type',
        'Company_id',
        'Category_id'*/
            $table->uuid('id')->primary();
            $table->string('title');
            $table->longText('description');
            $table->string('location');
            $table->decimal('salary', 10, 2);
            $table->enum('type',['Full-Time','Contract','Remote','Hybrid'])->default('Full-Time'); // e.g., full-time, part-time, contract
            $table->softDeletes();
            $table->timestamps();
            // Foreign keys
            $table->uuid('Company_id');
            $table->foreign('Company_id')->references('id')->on('companies')->onDelete('restrict');
            $table->uuid('Category_id');
            $table->foreign('Category_id')->references('id')->on('job_categories')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
