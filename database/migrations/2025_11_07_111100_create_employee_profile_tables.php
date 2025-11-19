<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Social links (single row per employee)
        if (!Schema::hasTable('employee_socials')) {
            Schema::create('employee_socials', function (Blueprint $table) {
                $table->id();
                $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
                $table->string('location')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('linkedin')->nullable();
                $table->string('facebook')->nullable();
                $table->string('twitter')->nullable();
                $table->string('instagram')->nullable();
                $table->string('github')->nullable();
                $table->string('website')->nullable();
                $table->string('current_position')->nullable();
                $table->string('company_name')->nullable();
                $table->string('skills')->nullable(); // comma separated
                $table->string('hobbies')->nullable(); // comma separated
                $table->decimal('total_experience_years', 4, 1)->nullable();
                $table->text('summary')->nullable();
                $table->string('resume_path')->nullable();
                $table->timestamps();
            });
        }

        // Repeaters
        if (!Schema::hasTable('employee_languages')) {
            Schema::create('employee_languages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
                $table->string('language');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('employee_previous_roles')) {
            Schema::create('employee_previous_roles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
                $table->string('title');
                $table->string('company')->nullable();
                $table->date('from_date')->nullable();
                $table->date('to_date')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('employee_educations')) {
            Schema::create('employee_educations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
                $table->string('degree');
                $table->string('institute')->nullable();
                $table->integer('year')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('employee_certifications')) {
            Schema::create('employee_certifications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
                $table->string('title');
                $table->string('issuer')->nullable();
                $table->integer('year')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('employee_achievements')) {
            Schema::create('employee_achievements', function (Blueprint $table) {
                $table->id();
                $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('years')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('employee_projects')) {
            Schema::create('employee_projects', function (Blueprint $table) {
                $table->id();
                $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('link')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('employee_profile_images')) {
            Schema::create('employee_profile_images', function (Blueprint $table) {
                $table->id();
                $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
                $table->string('image_path');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_profile_images');
        Schema::dropIfExists('employee_projects');
        Schema::dropIfExists('employee_achievements');
        Schema::dropIfExists('employee_certifications');
        Schema::dropIfExists('employee_educations');
        Schema::dropIfExists('employee_previous_roles');
        Schema::dropIfExists('employee_languages');
        Schema::dropIfExists('employee_socials');
    }
};
