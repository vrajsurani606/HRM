<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            if (!Schema::hasColumn('quotations', 'state_other')) {
                $table->string('state_other')->nullable()->after('state');
            }
            if (!Schema::hasColumn('quotations', 'city_other')) {
                $table->string('city_other')->nullable()->after('city');
            }
        });
    }

    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            if (Schema::hasColumn('quotations', 'state_other')) {
                $table->dropColumn('state_other');
            }
            if (Schema::hasColumn('quotations', 'city_other')) {
                $table->dropColumn('city_other');
            }
        });
    }
};
