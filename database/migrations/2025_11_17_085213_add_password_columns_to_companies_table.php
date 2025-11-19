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
            $table->string('company_password')->nullable()->after('company_email');
            $table->string('company_employee_email')->nullable()->after('company_password');
            $table->string('company_employee_password')->nullable()->after('company_employee_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['company_password', 'company_employee_email', 'company_employee_password']);
        });
    }
};
