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
        Schema::table('quotations', function (Blueprint $table) {
            // Check and add missing fields
            if (!Schema::hasColumn('quotations', 'scope_of_work')) {
                $table->text('scope_of_work')->nullable();
            }
            if (!Schema::hasColumn('quotations', 'contract_details')) {
                $table->text('contract_details')->nullable();
            }
            if (!Schema::hasColumn('quotations', 'company_email')) {
                $table->string('company_email')->nullable();
            }
            if (!Schema::hasColumn('quotations', 'company_password')) {
                $table->string('company_password')->nullable();
            }
            if (!Schema::hasColumn('quotations', 'amc_start_date')) {
                $table->date('amc_start_date')->nullable();
            }
            if (!Schema::hasColumn('quotations', 'amc_amount')) {
                $table->decimal('amc_amount', 12, 2)->nullable();
            }
            if (!Schema::hasColumn('quotations', 'project_start_date')) {
                $table->date('project_start_date')->nullable();
            }
            if (!Schema::hasColumn('quotations', 'completion_time')) {
                $table->string('completion_time')->nullable();
            }
            if (!Schema::hasColumn('quotations', 'retention_time')) {
                $table->string('retention_time')->nullable();
            }
            if (!Schema::hasColumn('quotations', 'retention_amount')) {
                $table->decimal('retention_amount', 12, 2)->nullable();
            }
            if (!Schema::hasColumn('quotations', 'website')) {
                $table->string('website')->nullable();
            }
            if (!Schema::hasColumn('quotations', 'email')) {
                $table->string('email')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $columnsToCheck = [
                'scope_of_work', 'contract_details', 'company_email', 'company_password',
                'amc_start_date', 'amc_amount', 'project_start_date', 'completion_time',
                'retention_time', 'retention_amount', 'website', 'email'
            ];
            
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('quotations', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};