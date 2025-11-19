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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('person_name_1')->nullable()->after('company_employee_password');
            $table->string('person_number_1')->nullable()->after('person_name_1');
            $table->string('person_position_1')->nullable()->after('person_number_1');
            $table->string('person_name_2')->nullable()->after('person_position_1');
            $table->string('person_number_2')->nullable()->after('person_name_2');
            $table->string('person_position_2')->nullable()->after('person_number_2');
            $table->string('person_name_3')->nullable()->after('person_position_2');
            $table->string('person_number_3')->nullable()->after('person_name_3');
            $table->string('person_position_3')->nullable()->after('person_number_3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'person_name_1',
                'person_number_1',
                'person_position_1',
                'person_name_2',
                'person_number_2',
                'person_position_2',
                'person_name_3',
                'person_number_3',
                'person_position_3'
            ]);
        });
    }
};
