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
            // Make fields nullable that were previously required
            $table->string('state', 50)->nullable()->change();
            $table->string('city', 50)->nullable()->change();
            $table->string('company_address', 500)->nullable()->change();
            $table->string('contact_person_name', 100)->nullable()->change();
            $table->string('contact_person_mobile', 20)->nullable()->change();
            $table->string('contact_person_position', 100)->nullable()->change();
            $table->string('company_type', 50)->nullable()->change();
            $table->string('person_name_1', 100)->nullable()->change();
            $table->string('person_number_1', 20)->nullable()->change();
            $table->string('person_position_1', 100)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            // Revert to non-nullable (note: this may fail if there are NULL values)
            $table->string('state', 50)->nullable(false)->change();
            $table->string('city', 50)->nullable(false)->change();
            $table->string('company_address', 500)->nullable(false)->change();
            $table->string('contact_person_name', 100)->nullable(false)->change();
            $table->string('contact_person_mobile', 20)->nullable(false)->change();
            $table->string('contact_person_position', 100)->nullable(false)->change();
            $table->string('company_type', 50)->nullable(false)->change();
            $table->string('person_name_1', 100)->nullable(false)->change();
            $table->string('person_number_1', 20)->nullable(false)->change();
            $table->string('person_position_1', 100)->nullable(false)->change();
        });
    }
};
