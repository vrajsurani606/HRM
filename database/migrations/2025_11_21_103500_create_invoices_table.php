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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proforma_id')->nullable()->constrained('proformas')->onDelete('set null');
            $table->string('unique_code')->unique();
            $table->date('invoice_date');
            $table->string('company_name');
            $table->string('bill_no')->nullable();
            $table->text('address')->nullable();
            $table->string('gst_no')->nullable();
            $table->string('mobile_no')->nullable();
            $table->json('description')->nullable();
            $table->json('sac_code')->nullable();
            $table->json('quantity')->nullable();
            $table->json('rate')->nullable();
            $table->json('total')->nullable();
            $table->decimal('sub_total', 10, 2)->nullable();
            $table->decimal('discount_percent', 10, 2)->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('retention_percent', 10, 2)->nullable();
            $table->decimal('retention_amount', 10, 2)->nullable();
            $table->decimal('cgst_percent', 10, 2)->nullable();
            $table->decimal('cgst_amount', 10, 2)->nullable();
            $table->decimal('sgst_percent', 10, 2)->nullable();
            $table->decimal('sgst_amount', 10, 2)->nullable();
            $table->decimal('igst_percent', 10, 2)->nullable();
            $table->decimal('igst_amount', 10, 2)->nullable();
            $table->decimal('final_amount', 10, 2)->nullable();
            $table->decimal('total_tax_amount', 10, 2)->nullable();
            $table->decimal('billing_item', 10, 2)->nullable();
            $table->string('type_of_billing')->nullable();
            $table->decimal('tds_amount', 10, 2)->nullable();
            $table->text('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
