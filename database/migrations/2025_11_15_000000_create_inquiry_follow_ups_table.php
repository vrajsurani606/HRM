<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('inquiry_follow_ups')) {
            Schema::create('inquiry_follow_ups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inquiry_id');
            $table->date('followup_date')->nullable();
            $table->date('next_followup_date')->nullable();
            $table->string('demo_status')->nullable();
            $table->date('scheduled_demo_date')->nullable();
            $table->time('scheduled_demo_time')->nullable();
            $table->date('demo_date')->nullable();
            $table->time('demo_time')->nullable();
            $table->text('remark')->nullable();
            $table->text('inquiry_note')->nullable();
            $table->timestamps();

            $table->foreign('inquiry_id')->references('id')->on('inquiries')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiry_follow_ups');
    }
};
