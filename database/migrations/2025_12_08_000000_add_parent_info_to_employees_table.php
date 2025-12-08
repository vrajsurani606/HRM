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
        Schema::table('employees', function (Blueprint $table) {
            $table->string('mother_name')->nullable()->after('marital_status');
            $table->string('mother_mobile_no', 20)->nullable()->after('mother_name');
            $table->string('father_name')->nullable()->after('mother_mobile_no');
            $table->string('father_mobile_no', 20)->nullable()->after('father_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'mother_name',
                'mother_mobile_no',
                'father_name',
                'father_mobile_no',
            ]);
        });
    }
};
