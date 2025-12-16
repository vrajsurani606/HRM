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
        if (Schema::hasTable('hiring_leads')) {
            Schema::table('hiring_leads', function (Blueprint $table) {
                if (!Schema::hasColumn('hiring_leads', 'reject_reason')) {
                    $table->text('reject_reason')->nullable()->after('status');
                }
                if (!Schema::hasColumn('hiring_leads', 'status_changed_at')) {
                    $table->timestamp('status_changed_at')->nullable()->after('reject_reason');
                }
                if (!Schema::hasColumn('hiring_leads', 'status_changed_by')) {
                    $table->unsignedBigInteger('status_changed_by')->nullable()->after('status_changed_at');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hiring_leads', function (Blueprint $table) {
            $table->dropColumn(['reject_reason', 'status_changed_at', 'status_changed_by']);
        });
    }
};
