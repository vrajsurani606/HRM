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
        Schema::table('quotations', function (Blueprint $table) {
            $table->date('tentative_complete_date_2')->nullable()->after('tentative_complete_date');
            $table->text('custom_terms')->nullable()->after('contract_amount');
            $table->string('prepared_by')->nullable()->after('custom_terms');
            $table->string('mobile_no', 20)->nullable()->after('prepared_by');
            $table->string('footer_company_name')->nullable()->after('mobile_no');
            $table->json('services_1')->nullable()->after('footer_company_name');
            $table->json('services_2')->nullable()->after('services_1');
            $table->json('features')->nullable()->after('services_2');
            $table->json('basic_cost')->nullable()->after('features');
            $table->json('additional_cost')->nullable()->after('basic_cost');
            $table->json('maintenance_cost')->nullable()->after('additional_cost');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn([
                'tentative_complete_date_2',
                'custom_terms',
                'prepared_by',
                'mobile_no',
                'footer_company_name',
                'services_1',
                'services_2',
                'features',
                'basic_cost',
                'additional_cost',
                'maintenance_cost'
            ]);
        });
    }
};
