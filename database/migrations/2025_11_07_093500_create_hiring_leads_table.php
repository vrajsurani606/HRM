<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('hiring_leads')) {
            Schema::create('hiring_leads', function (Blueprint $table) {
            $table->id();
            $table->string('unique_code')->unique();
            $table->string('person_name');
            $table->string('mobile_no', 20);
            $table->string('address')->nullable();
            $table->string('position')->nullable();
            $table->boolean('is_experience')->default(false);
            $table->decimal('experience_count', 4, 1)->nullable();
            $table->string('experience_previous_company')->nullable();
            $table->decimal('previous_salary', 12, 2)->nullable();
            $table->string('resume_path')->nullable();
            $table->enum('gender', ['male','female','other'])->nullable();
            $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('hiring_leads');
    }
};
