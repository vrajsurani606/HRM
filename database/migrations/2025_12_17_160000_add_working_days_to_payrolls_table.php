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
            if (!Schema::hasColumn('payrolls', 'total_working_days')) {
                $table->integer('total_working_days')->nullable()->after('year');
            }
            if (!Schema::hasColumn('payrolls', 'attended_working_days')) {
                $table->integer('attended_working_days')->nullable()->after('total_working_days');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->dropColumn(['total_working_days', 'attended_working_days']);
        });
    }
};
