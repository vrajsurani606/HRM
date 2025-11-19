<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            // For SQLite, we need to create a new table and copy data
            Schema::table('employee_letters', function (Blueprint $table) {
                $table->string('temp_type')->after('type');
            });
            
            DB::table('employee_letters')->update([
                'temp_type' => DB::raw('type')
            ]);
            
            Schema::table('employee_letters', function (Blueprint $table) {
                $table->dropColumn('type');
            });
            
            Schema::table('employee_letters', function (Blueprint $table) {
                $table->enum('type', [
                    'appointment', 'offer', 'joining', 'confidentiality', 
                    'impartiality', 'experience', 'agreement', 'relieving', 
                    'confirmation', 'warning', 'termination', 'increment',
                    'internship_offer', 'internship_letter', 'other'
                ])->after('id');
            });
            
            DB::table('employee_letters')->update([
                'type' => DB::raw('temp_type')
            ]);
            
            Schema::table('employee_letters', function (Blueprint $table) {
                $table->dropColumn('temp_type');
            });
        } else {
            // For other databases
            DB::statement("ALTER TABLE employee_letters MODIFY COLUMN type ENUM('appointment', 'offer', 'joining', 'confidentiality', 'impartiality', 'experience', 'agreement', 'relieving', 'confirmation', 'warning', 'termination', 'increment', 'internship_offer', 'internship_letter', 'other') NOT NULL");
        }

        // Add new fields for increment and internship letters
        Schema::table('employee_letters', function (Blueprint $table) {
            $table->decimal('increment_amount', 12, 2)->nullable()->after('salary_increment');
            $table->date('increment_effective_date')->nullable()->after('increment_amount');
            $table->string('internship_position', 190)->nullable()->after('increment_effective_date');
            $table->date('internship_start_date')->nullable()->after('internship_position');
            $table->date('internship_end_date')->nullable()->after('internship_start_date');
            $table->text('internship_address')->nullable()->after('internship_end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the new fields
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

        if (DB::getDriverName() === 'sqlite') {
            // For SQLite, we need to create a new table and copy data
            Schema::table('employee_letters', function (Blueprint $table) {
                $table->string('temp_type')->after('type');
            });
            
            DB::table('employee_letters')->update([
                'temp_type' => DB::raw('type')
            ]);
            
            Schema::table('employee_letters', function (Blueprint $table) {
                $table->dropColumn('type');
            });
            
            Schema::table('employee_letters', function (Blueprint $table) {
                $table->enum('type', [
                    'appointment', 'offer', 'joining', 'confidentiality', 
                    'impartiality', 'experience', 'agreement', 'relieving', 
                    'confirmation', 'warning', 'termination', 'other'
                ])->after('id');
            });
            
            // Only keep valid values when rolling back
            DB::table('employee_letters')
                ->whereNotIn('temp_type', ['appointment', 'offer', 'joining', 'confidentiality', 'impartiality', 'experience', 'agreement', 'relieving', 'confirmation', 'warning', 'termination', 'other'])
                ->update(['temp_type' => 'other']);
                
            DB::table('employee_letters')->update([
                'type' => DB::raw('temp_type')
            ]);
            
            Schema::table('employee_letters', function (Blueprint $table) {
                $table->dropColumn('temp_type');
            });
        } else {
            // For other databases
            DB::statement("ALTER TABLE employee_letters MODIFY COLUMN type ENUM('appointment', 'offer', 'joining', 'confidentiality', 'impartiality', 'experience', 'agreement', 'relieving', 'confirmation', 'warning', 'termination', 'other') NOT NULL");
        }
    }
};