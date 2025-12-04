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
        if (!Schema::hasTable('notes')) {
            Schema::create('notes', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable(); // Admin/Creator
                $table->unsignedBigInteger('employee_id')->nullable(); // Target employee
                $table->enum('type', ['system', 'employee'])->default('employee');
                $table->text('content');
                $table->json('assignees')->nullable();
                $table->timestamps();
                
                // Foreign keys
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');
                
                // Indexes for faster queries
                $table->index('employee_id');
                $table->index('user_id');
                $table->index('type');
                $table->index('created_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
