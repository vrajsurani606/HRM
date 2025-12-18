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
        Schema::table('companies', function (Blueprint $table) {
            if (!Schema::hasColumn('companies', 'company_password_plain')) {
                $table->string('company_password_plain')->nullable()->after('company_password');
            }
            if (!Schema::hasColumn('companies', 'company_employee_password_plain')) {
                $table->string('company_employee_password_plain')->nullable()->after('company_employee_password');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            if (Schema::hasColumn('companies', 'company_password_plain')) {
                $table->dropColumn('company_password_plain');
            }
            if (Schema::hasColumn('companies', 'company_employee_password_plain')) {
                $table->dropColumn('company_employee_password_plain');
            }
        });
    }
};
