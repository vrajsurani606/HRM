<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('note_employee', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('note_id');
            $table->unsignedBigInteger('employee_id');
            $table->dateTime('read_at')->nullable();
            $table->dateTime('acknowledged_at')->nullable();
            $table->timestamps();

            $table->foreign('note_id')->references('id')->on('notes')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->unique(['note_id', 'employee_id']);
            $table->index('read_at');
            $table->index('acknowledged_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('note_employee');
    }
};
