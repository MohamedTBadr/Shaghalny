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
        Schema::create('resumes', function (Blueprint $table) {
            //
            //'file_name','fileUrl','Contact_details','summary','education','skills','experience','user_id'

            $table->uuid('id')->primary();
            $table->string('file_name');
            $table->string('fileUrl');
            $table->longText('Contact_details')->nullable();
            $table->longText('summary')->nullable();
            $table->longText('education')->nullable();
            $table->longText('skills')->nullable();
            $table->longText('experience')->nullable();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->softDeletes();
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
