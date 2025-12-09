<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (!Schema::hasColumn('tickets', 'company_id')) {
                $table->unsignedBigInteger('company_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('tickets', 'project_id')) {
                $table->unsignedBigInteger('project_id')->nullable()->after('company_id');
            }
            if (!Schema::hasColumn('tickets', 'completed_at')) {
                $table->timestamp('completed_at')->nullable();
            }
            if (!Schema::hasColumn('tickets', 'completed_by')) {
                $table->unsignedBigInteger('completed_by')->nullable();
            }
            if (!Schema::hasColumn('tickets', 'confirmed_at')) {
                $table->timestamp('confirmed_at')->nullable();
            }
            if (!Schema::hasColumn('tickets', 'confirmed_by')) {
                $table->unsignedBigInteger('confirmed_by')->nullable();
            }
            if (!Schema::hasColumn('tickets', 'resolution_notes')) {
                $table->text('resolution_notes')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn([
                'company_id',
                'project_id', 
                'completed_at',
                'completed_by',
                'confirmed_at',
                'confirmed_by',
                'resolution_notes'
            ]);
        });
    }
};
