<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('digital_cards')) {
            Schema::create('digital_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            
            // Basic Information
            $table->string('full_name');
            $table->string('current_position');
            $table->string('company_name');
            $table->integer('years_of_experience');
            
            // Contact Information
            $table->string('email');
            $table->string('phone');
            $table->string('linkedin_profile')->nullable();
            $table->string('portfolio_website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('github')->nullable();
            
            // Location & Preferences
            $table->text('location');
            
            // Skills & Summary
            $table->text('skills');
            $table->text('hobbies_interests')->nullable();
            $table->text('professional_summary')->nullable();
            
            // Previous Roles (JSON for multiple roles)
            $table->json('previous_roles')->nullable();
            
            // Education (JSON for multiple education entries)
            $table->json('education')->nullable();
            
            // Certifications (JSON for multiple certifications)
            $table->json('certifications')->nullable();
            
            // Gallery (JSON for multiple files)
            $table->json('gallery')->nullable();
            
            // Achievements & Awards (JSON for multiple achievements)
            $table->json('achievements')->nullable();
            
            // Languages (JSON for multiple languages)
            $table->json('languages')->nullable();
            
            // Projects / Portfolio (JSON for multiple projects)
            $table->json('projects')->nullable();
            
            // Resume file path
            $table->string('resume_path')->nullable();
            
            $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('digital_cards');
    }
};