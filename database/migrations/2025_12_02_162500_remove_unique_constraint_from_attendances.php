<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Remove the unique constraint on employee_id + date to allow multiple check-in/out entries per day
     */
    public function up(): void
    {
        // First add a regular index on employee_id (needed for foreign key)
        Schema::table('attendances', function (Blueprint $table) {
            $table->index('employee_id', 'attendances_employee_id_index');
        });

        // Now drop the unique constraint
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropUnique('attendances_employee_id_date_unique');
        });

        // Add a non-unique index on employee_id + date for query performance
        Schema::table('attendances', function (Blueprint $table) {
            $table->index(['employee_id', 'date'], 'attendances_employee_id_date_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Drop the non-unique index
            $table->dropIndex('attendances_employee_id_date_index');
        });

        Schema::table('attendances', function (Blueprint $table) {
            // Re-add the unique constraint
            $table->unique(['employee_id', 'date'], 'attendances_employee_id_date_unique');
        });

        Schema::table('attendances', function (Blueprint $table) {
            // Drop the regular index
            $table->dropIndex('attendances_employee_id_index');
        });
    }
};
