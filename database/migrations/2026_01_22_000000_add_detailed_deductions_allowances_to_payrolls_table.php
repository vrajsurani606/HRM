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
            // Add detailed allowance fields if they don't exist
            if (!Schema::hasColumn('payrolls', 'hra')) {
                $table->decimal('hra', 10, 2)->nullable()->after('basic_salary');
            }
            if (!Schema::hasColumn('payrolls', 'dearness_allowance')) {
                $table->decimal('dearness_allowance', 10, 2)->nullable()->after('hra');
            }
            if (!Schema::hasColumn('payrolls', 'city_allowance')) {
                $table->decimal('city_allowance', 10, 2)->nullable()->after('dearness_allowance');
            }
            if (!Schema::hasColumn('payrolls', 'medical_allowance')) {
                $table->decimal('medical_allowance', 10, 2)->nullable()->after('city_allowance');
            }
            if (!Schema::hasColumn('payrolls', 'tiffin_allowance')) {
                $table->decimal('tiffin_allowance', 10, 2)->nullable()->after('medical_allowance');
            }
            if (!Schema::hasColumn('payrolls', 'assistant_allowance')) {
                $table->decimal('assistant_allowance', 10, 2)->nullable()->after('tiffin_allowance');
            }
            
            // Add detailed deduction fields if they don't exist
            if (!Schema::hasColumn('payrolls', 'pf')) {
                $table->decimal('pf', 10, 2)->nullable()->after('bonuses');
            }
            if (!Schema::hasColumn('payrolls', 'professional_tax')) {
                $table->decimal('professional_tax', 10, 2)->nullable()->after('pf');
            }
            if (!Schema::hasColumn('payrolls', 'tds')) {
                $table->decimal('tds', 10, 2)->nullable()->after('professional_tax');
            }
            if (!Schema::hasColumn('payrolls', 'esic')) {
                $table->decimal('esic', 10, 2)->nullable()->after('tds');
            }
            if (!Schema::hasColumn('payrolls', 'security_deposit')) {
                $table->decimal('security_deposit', 10, 2)->nullable()->after('esic');
            }
            if (!Schema::hasColumn('payrolls', 'leave_deduction')) {
                $table->decimal('leave_deduction', 10, 2)->nullable()->after('security_deposit');
            }
            if (!Schema::hasColumn('payrolls', 'leave_deduction_days')) {
                $table->decimal('leave_deduction_days', 5, 2)->nullable()->after('leave_deduction');
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
                'hra',
                'dearness_allowance', 
                'city_allowance',
                'medical_allowance',
                'tiffin_allowance',
                'assistant_allowance',
                'pf',
                'professional_tax',
                'tds',
                'esic',
                'security_deposit',
                'leave_deduction',
                'leave_deduction_days'
            ]);
        });
    }
};