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
        Schema::create('quotation_follow_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->onDelete('cascade');
            $table->date('followup_date')->nullable();
            $table->date('next_followup_date')->nullable();
            $table->string('demo_status')->nullable();
            $table->date('scheduled_demo_date')->nullable();
            $table->string('scheduled_demo_time')->nullable();
            $table->date('demo_date')->nullable();
            $table->string('demo_time')->nullable();
            $table->text('remark')->nullable();
            $table->string('quotation_note')->nullable();
            $table->boolean('is_confirm')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_follow_ups');
    }
};
