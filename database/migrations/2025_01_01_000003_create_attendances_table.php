<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('attendances')) {
            Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->date('date')->index();
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->time('total_working_hours')->nullable();
            $table->enum('status', ['present', 'absent', 'half_day', 'leave'])->default('absent');
            $table->text('notes')->nullable();
            $table->string('check_in_ip')->nullable();
            $table->string('check_out_ip')->nullable();
            $table->string('check_in_location')->nullable();
            $table->string('check_out_location')->nullable();
            $table->timestamps();
            
            // Composite unique key to ensure one entry per employee per day
            $table->unique(['employee_id', 'date']);
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};
