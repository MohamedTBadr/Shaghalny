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
        Schema::create('companies', function (Blueprint $table) {
            //
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('address');
            $table->string('industry');
            $table->string('website')->nullable();
            //relationship with users table
            $table->uuid('Owner_id')->nullable();
            $table->foreign('Owner_id')->references('id')->on('users')->onDelete('restrict');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::dropIfExists('companies');
    }
};
