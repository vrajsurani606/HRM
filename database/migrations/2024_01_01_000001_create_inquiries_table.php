<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('inquiries')) {
            Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('unique_code')->unique();
            $table->date('inquiry_date');
            $table->string('company_name');
            $table->text('company_address');
            $table->string('industry_type');
            $table->string('email');
            $table->string('company_phone');
            $table->string('city');
            $table->string('state');
            $table->string('contact_mobile');
            $table->string('contact_name');
            $table->string('scope_link')->nullable();
            $table->string('contact_position');
            $table->string('quotation_file')->nullable();
            $table->string('quotation_sent')->nullable();
            $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};