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
        // Modify the ENUM to include 'hold' status
        DB::statement("ALTER TABLE payrolls MODIFY COLUMN status ENUM('pending', 'paid', 'hold', 'cancelled') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original ENUM (without 'hold')
        // First update any 'hold' status to 'pending'
        DB::statement("UPDATE payrolls SET status = 'pending' WHERE status = 'hold'");
        DB::statement("ALTER TABLE payrolls MODIFY COLUMN status ENUM('pending', 'paid', 'cancelled') DEFAULT 'pending'");
    }
};
