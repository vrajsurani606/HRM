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
        Schema::table('roles', function (Blueprint $table) {
            $table->string('dashboard_type', 50)->default('admin')->after('restrict_to_own_data')
                  ->comment('Dashboard view type: admin, employee, customer, hr, receptionist');
        });
        
        // Update existing roles with appropriate dashboard types
        DB::table('roles')->where('name', 'employee')->update(['dashboard_type' => 'employee']);
        DB::table('roles')->where('name', 'customer')->update(['dashboard_type' => 'customer']);
        DB::table('roles')->where('name', 'client')->update(['dashboard_type' => 'customer']);
        DB::table('roles')->where('name', 'hr')->update(['dashboard_type' => 'hr']);
        DB::table('roles')->where('name', 'receptionist')->update(['dashboard_type' => 'receptionist']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('dashboard_type');
        });
    }
};
