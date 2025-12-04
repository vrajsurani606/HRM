<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Modify the status enum to include 'late' and 'early_leave'
        DB::statement("ALTER TABLE attendances MODIFY COLUMN status ENUM('present', 'absent', 'half_day', 'leave', 'late', 'early_leave') DEFAULT 'absent'");
    }

    public function down()
    {
        // Revert to original enum
        DB::statement("ALTER TABLE attendances MODIFY COLUMN status ENUM('present', 'absent', 'half_day', 'leave') DEFAULT 'absent'");
    }
};
