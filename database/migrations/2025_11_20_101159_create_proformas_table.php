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
        Schema::create('proformas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->onDelete('cascade');
            $table->string('unique_code')->unique();
            $table->date('proforma_date');
            $table->string('company_name');
            $table->string('bill_no')->nullable();
            $table->text('address')->nullable();
            $table->string('gst_no')->nullable();
            $table->string('mobile_no')->nullable();
            
            // Service items (JSON arrays)
            $table->json('description')->nullable();
            $table->json('sac_code')->nullable();
            $table->json('quantity')->nullable();
            $table->json('rate')->nullable();
            $table->json('total')->nullable();
            
            // Tax calculations
            $table->decimal('sub_total', 15, 2)->default(0);
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('cgst_percent', 5, 2)->default(0);
            $table->decimal('cgst_amount', 15, 2)->default(0);
            $table->decimal('sgst_percent', 5, 2)->default(0);
            $table->decimal('sgst_amount', 15, 2)->default(0);
            $table->decimal('igst_percent', 5, 2)->default(0);
            $table->decimal('igst_amount', 15, 2)->default(0);
            $table->decimal('final_amount', 15, 2)->default(0);
            $table->decimal('total_tax_amount', 15, 2)->default(0);
            $table->decimal('billing_item', 15, 2)->default(0);
            $table->string('type_of_billing')->nullable();
            
            $table->text('tds_amount')->nullable();
            $table->text('remark')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proformas');
    }
};
