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
        Schema::create('employee_letters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('reference_number')->unique();
            $table->string('title');
            $table->text('content');
            $table->enum('type', ['appointment', 'experience', 'relieving', 'other']);
            $table->date('issue_date');
            $table->text('notes')->nullable();
            $table->text('note')->nullable();
            $table->decimal('monthly_salary', 12, 2)->nullable();
            $table->decimal('annual_ctc', 12, 2)->nullable();
            $table->string('reporting_manager', 190)->nullable();
            $table->string('working_hours', 190)->nullable();
            $table->date('date_of_joining')->nullable();
            $table->text('probation_period')->nullable();
            $table->text('salary_increment')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_letters');
    }
};
