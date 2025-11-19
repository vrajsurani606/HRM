<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('digital_cards', function (Blueprint $table) {
            // Add missing columns that exist in your PHP file
            if (!Schema::hasColumn('digital_cards', 'um_id')) {
                $table->unsignedBigInteger('um_id')->nullable()->after('employee_id');
            }
            
            if (!Schema::hasColumn('digital_cards', 'experience_years')) {
                $table->integer('experience_years')->nullable()->after('years_of_experience');
            }
            
            if (!Schema::hasColumn('digital_cards', 'willing_to')) {
                $table->text('willing_to')->nullable()->after('professional_summary');
            }
            
            if (!Schema::hasColumn('digital_cards', 'previous_roles')) {
                $table->json('previous_roles')->nullable();
            }
            
            if (!Schema::hasColumn('digital_cards', 'resume')) {
                $table->string('resume')->nullable()->after('resume_path');
            }
            
            // Rename columns to match PHP implementation
            if (Schema::hasColumn('digital_cards', 'linkedin_profile')) {
                $table->renameColumn('linkedin_profile', 'linkedin');
            }
            
            if (Schema::hasColumn('digital_cards', 'portfolio_website')) {
                $table->renameColumn('portfolio_website', 'portfolio');
            }
            
            if (Schema::hasColumn('digital_cards', 'hobbies_interests')) {
                $table->renameColumn('hobbies_interests', 'hobbies');
            }
            
            if (Schema::hasColumn('digital_cards', 'professional_summary')) {
                $table->renameColumn('professional_summary', 'summary');
            }
        });
    }

    public function down(): void
    {
        Schema::table('digital_cards', function (Blueprint $table) {
            $table->dropColumn(['um_id', 'experience_years', 'willing_to', 'resume']);
            
            if (Schema::hasColumn('digital_cards', 'linkedin')) {
                $table->renameColumn('linkedin', 'linkedin_profile');
            }
            
            if (Schema::hasColumn('digital_cards', 'portfolio')) {
                $table->renameColumn('portfolio', 'portfolio_website');
            }
            
            if (Schema::hasColumn('digital_cards', 'hobbies')) {
                $table->renameColumn('hobbies', 'hobbies_interests');
            }
            
            if (Schema::hasColumn('digital_cards', 'summary')) {
                $table->renameColumn('summary', 'professional_summary');
            }
        });
    }
};