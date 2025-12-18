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
        Schema::table('payrolls', function (Blueprint $table) {
            // Add leave type fields if they don't exist
            if (!Schema::hasColumn('payrolls', 'casual_leave')) {
                $table->decimal('casual_leave', 5, 1)->nullable()->default(0)->after('attended_working_days');
            }
            if (!Schema::hasColumn('payrolls', 'medical_leave')) {
                $table->decimal('medical_leave', 5, 1)->nullable()->default(0)->after('casual_leave');
            }
            if (!Schema::hasColumn('payrolls', 'holiday_leave')) {
                $table->decimal('holiday_leave', 5, 1)->nullable()->default(0)->after('medical_leave');
            }
            if (!Schema::hasColumn('payrolls', 'personal_leave_unpaid')) {
                $table->decimal('personal_leave_unpaid', 5, 1)->nullable()->default(0)->after('holiday_leave');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->dropColumn([
                'casual_leave',
                'medical_leave',
                'holiday_leave',
                'personal_leave_unpaid'
            ]);
        });
    }
};
