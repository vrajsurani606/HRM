<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('receipts')) {
            Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->string('unique_code');
            $table->date('rec_date');
            $table->string('company_name');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('paid_amount', 10, 2);
            $table->decimal('remain_amount', 10, 2);
            $table->decimal('received_amount', 10, 2);
            $table->enum('payment_type', ['cash', 'cheque', 'bank_transfer', 'online']);
            $table->text('narration');
            $table->string('trans_code');
            $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};