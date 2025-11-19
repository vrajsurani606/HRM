<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('quotations')) {
            Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inquiry_id')->nullable();
            $table->string('unique_code')->nullable();
            $table->string('quotation_title')->nullable();
            $table->date('quotation_date')->nullable();
            $table->string('customer_type')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('gst_no')->nullable();
            $table->string('pan_no')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_type')->nullable();
            $table->string('nature_of_work')->nullable();
            $table->string('city')->nullable();
            $table->text('scope_of_work')->nullable();
            $table->text('address')->nullable();
            $table->string('contact_person_1')->nullable();
            $table->string('contact_number_1')->nullable();
            $table->string('position_1')->nullable();
            $table->string('contract_copy_path')->nullable();
            $table->text('contract_details')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_password')->nullable();
            $table->date('amc_start_date')->nullable();
            $table->decimal('amc_amount', 12, 2)->nullable();
            $table->date('project_start_date')->nullable();
            $table->string('completion_time')->nullable();
            $table->string('retention_time')->nullable();
            $table->decimal('retention_amount', 12, 2)->nullable();
            $table->date('tentative_complete_date')->nullable();
            $table->decimal('contract_amount', 12, 2)->nullable();
            $table->string('status')->default('draft');
            $table->timestamps();

            $table->foreign('inquiry_id')->references('id')->on('inquiries')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
