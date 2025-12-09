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
        Schema::table('tickets', function (Blueprint $table) {
            // Add company_id and project_id if they don't exist
            if (!Schema::hasColumn('tickets', 'company_id')) {
                $table->unsignedBigInteger('company_id')->nullable()->after('company');
            }
            if (!Schema::hasColumn('tickets', 'project_id')) {
                $table->unsignedBigInteger('project_id')->nullable()->after('company_id');
            }
        });
        
        // Update status enum to include 'needs_approval' and 'pending'
        DB::statement("ALTER TABLE tickets MODIFY COLUMN status ENUM('open','pending','needs_approval','in_progress','resolved','closed') DEFAULT 'open'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (Schema::hasColumn('tickets', 'company_id')) {
                $table->dropColumn('company_id');
            }
            if (Schema::hasColumn('tickets', 'project_id')) {
                $table->dropColumn('project_id');
            }
        });
        
        // Revert status enum
        DB::statement("ALTER TABLE tickets MODIFY COLUMN status ENUM('open','in_progress','resolved','closed') DEFAULT 'open'");
    }
};
