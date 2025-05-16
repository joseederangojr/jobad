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
        Schema::create('job_ads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subcompany');
            $table->string('office');
            $table->string('department');
            $table->string('recruiting_category');
            $table->string('employment_type');
            $table->string('seniority');
            $table->string('schedule');
            $table->string('years_of_experience');
            $table->json('keywords')->default('[]');
            $table->string('occupation');
            $table->string('occupation_category');
            $table->json('job_descriptions')->default('[]');
            $table->string('status', 20)->default('pending');
            $table->unsignedBigInteger('created_by_id');
            $table->unsignedBigInteger('updated_by_id');
            $table->unsignedBigInteger('deleted_by_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by_id')->references('id')->on('users');
            $table->foreign('updated_by_id')->references('id')->on('users');
            $table->foreign('deleted_by_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_ads');
    }
};
