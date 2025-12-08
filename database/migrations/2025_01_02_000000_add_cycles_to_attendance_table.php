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
        Schema::table('attendances', function (Blueprint $table) {
            // Add cycles column to store multiple check-in/out cycles as JSON
            if (!Schema::hasColumn('attendances', 'cycles')) {
                $table->json('cycles')->nullable()->after('check_out')->comment('JSON array of previous check-in/out cycles');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            if (Schema::hasColumn('attendances', 'cycles')) {
                $table->dropColumn('cycles');
            }
        });
    }
};
