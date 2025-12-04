<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Check if notes table exists and add missing columns
        if (Schema::hasTable('notes')) {
            Schema::table('notes', function (Blueprint $table) {
                // Add columns if they don't exist
                if (!Schema::hasColumn('notes', 'title')) {
                    $table->string('title')->nullable()->after('id');
                }
                if (!Schema::hasColumn('notes', 'priority')) {
                    $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium')->after('content');
                }
                if (!Schema::hasColumn('notes', 'status')) {
                    $table->enum('status', ['pending', 'in_progress', 'completed', 'urgent'])->default('pending')->after('priority');
                }
                if (!Schema::hasColumn('notes', 'type')) {
                    $table->enum('type', ['admin', 'employee', 'system'])->default('admin')->after('status');
                }
                if (!Schema::hasColumn('notes', 'due_date')) {
                    $table->dateTime('due_date')->nullable()->after('type');
                }
                if (!Schema::hasColumn('notes', 'created_by')) {
                    $table->unsignedBigInteger('created_by')->nullable()->after('due_date');
                }
            });
        }
    }

    public function down(): void
    {
        // Rollback is not needed for this migration
    }
};
