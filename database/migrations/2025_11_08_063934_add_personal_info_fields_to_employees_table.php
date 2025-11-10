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
        Schema::table('employees', function (Blueprint $table) {
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('name');
            $table->date('date_of_birth')->nullable()->after('gender');
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->nullable()->after('date_of_birth');
            $table->string('highest_qualification')->nullable()->after('pan_no');
            $table->year('year_of_passing')->nullable()->after('highest_qualification');
            $table->string('previous_designation')->nullable()->after('previous_company_name');
            $table->string('duration')->nullable()->after('previous_designation');
            $table->text('reason_for_leaving')->nullable()->after('duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'gender',
                'date_of_birth',
                'marital_status',
                'highest_qualification',
                'year_of_passing',
                'previous_designation',
                'duration',
                'reason_for_leaving',
            ]);
        });
    }
};
