<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('tickets')) {
            Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_no')->unique();
            $table->string('subject');
            $table->enum('status', ['open','in_progress','resolved','closed'])->default('open');
            $table->enum('priority', ['low','medium','high','urgent'])->default('medium');
            $table->string('assigned_to')->nullable();
            $table->string('opened_by')->nullable();
            $table->timestamp('opened_at')->nullable();
            // Extra fields for UI columns/filters
            $table->enum('work_status', ['completed','not_assigned','in_progress','on_hold'])->default('not_assigned');
            $table->string('category')->nullable();
            $table->string('customer')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('company')->nullable();
            $table->string('ticket_type')->nullable();
            $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
