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
            $table->string('contact_gender_1')->nullable()->after('contact_person_1');
            $table->string('contact_gender_2')->nullable()->after('contact_person_2');
            $table->string('contact_gender_3')->nullable()->after('contact_person_3');
            $table->string('prepared_by_gender')->nullable()->after('prepared_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn(['contact_gender_1', 'contact_gender_2', 'contact_gender_3', 'prepared_by_gender']);
        });
    }
};
