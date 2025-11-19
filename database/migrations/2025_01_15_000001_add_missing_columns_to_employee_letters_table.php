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
        Schema::table('employee_letters', function (Blueprint $table) {
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('employee_letters', 'internship_position')) {
                $table->string('internship_position', 190)->nullable();
            }
            if (!Schema::hasColumn('employee_letters', 'internship_start_date')) {
                $table->date('internship_start_date')->nullable();
            }
            if (!Schema::hasColumn('employee_letters', 'internship_end_date')) {
                $table->date('internship_end_date')->nullable();
            }
            if (!Schema::hasColumn('employee_letters', 'internship_address')) {
                $table->text('internship_address')->nullable();
            }
            if (!Schema::hasColumn('employee_letters', 'increment_amount')) {
                $table->decimal('increment_amount', 12, 2)->nullable();
            }
            if (!Schema::hasColumn('employee_letters', 'increment_effective_date')) {
                $table->date('increment_effective_date')->nullable();
            }
        });
        
        // Update the type enum
        \DB::statement("ALTER TABLE employee_letters MODIFY COLUMN type ENUM(
            'appointment', 'offer', 'joining', 'confidentiality', 'impartiality', 
            'experience', 'agreement', 'relieving', 'confirmation', 'warning', 
            'termination', 'increment', 'internship_offer', 'internship_letter', 'other'
        )");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_letters', function (Blueprint $table) {
            $table->dropColumn([
                'increment_amount',
                'increment_effective_date',
                'internship_position',
                'internship_start_date',
                'internship_end_date',
                'internship_address'
            ]);
        });
        
        \DB::statement("ALTER TABLE employee_letters MODIFY COLUMN type ENUM('appointment', 'experience', 'relieving', 'other')");
    }
};