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
                    'confirmation', 'warning', 'termination', 'other'
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
            DB::statement("ALTER TABLE employee_letters MODIFY COLUMN type ENUM('appointment', 'offer', 'joining', 'confidentiality', 'impartiality', 'experience', 'agreement', 'relieving', 'confirmation', 'warning', 'termination', 'other') NOT NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
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
                    'appointment', 'experience', 'relieving', 'other'
                ])->after('id');
            });
            
            // Only keep valid values when rolling back
            DB::table('employee_letters')
                ->whereNotIn('temp_type', ['appointment', 'experience', 'relieving', 'other'])
                ->update(['temp_type' => 'other']);
                
            DB::table('employee_letters')->update([
                'type' => DB::raw('temp_type')
            ]);
            
            Schema::table('employee_letters', function (Blueprint $table) {
                $table->dropColumn('temp_type');
            });
        } else {
            // For other databases
            DB::statement("ALTER TABLE employee_letters MODIFY COLUMN type ENUM('appointment', 'experience', 'relieving', 'other') NOT NULL");
        }
    }
};
