<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('offer_letters')) {
            Schema::create('offer_letters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hiring_lead_id')->constrained('hiring_leads')->cascadeOnDelete();
            $table->date('issue_date');
            $table->text('note')->nullable();
            $table->decimal('monthly_salary', 12, 2)->nullable();
            $table->decimal('annual_ctc', 12, 2)->nullable();
            $table->string('reporting_manager', 190)->nullable();
            $table->string('working_hours', 190)->nullable();
            $table->date('date_of_joining')->nullable();
            $table->text('probation_period')->nullable();
            $table->text('salary_increment')->nullable();
            $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('offer_letters');
    }
};
