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
        if (!Schema::hasTable('companies')) {
            Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('unique_code')->unique()->nullable();
            $table->string('company_name');
            $table->string('gst_no')->nullable();
            $table->string('pan_no')->nullable();
            $table->text('company_address');
            $table->string('state');
            $table->string('city');
            $table->string('contact_person_name');
            $table->string('contact_person_mobile');
            $table->string('contact_person_position')->nullable();
            $table->string('company_email')->unique();
            $table->string('company_phone')->nullable();
            $table->string('company_type');
            $table->text('other_details')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('scope_link')->nullable();
            $table->timestamps();
            $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
