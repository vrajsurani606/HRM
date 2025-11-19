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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inquiry_id')->nullable();
            $table->string('unique_code')->unique();
            $table->string('quotation_title');
            $table->date('quotation_date');
            $table->enum('customer_type', ['new', 'existing']);
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('gst_no')->nullable();
            $table->string('pan_no')->nullable();
            $table->string('company_name');
            $table->string('company_type')->nullable();
            $table->string('nature_of_work')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->text('scope_of_work')->nullable();
            $table->text('address')->nullable();
            $table->string('contact_person_1')->nullable();
            $table->string('contact_number_1')->nullable();
            $table->string('position_1')->nullable();
            $table->string('contact_person_2')->nullable();
            $table->string('contact_number_2')->nullable();
            $table->string('position_2')->nullable();
            $table->string('contact_person_3')->nullable();
            $table->string('contact_number_3')->nullable();
            $table->string('position_3')->nullable();
            $table->string('contract_copy')->nullable();
            $table->text('contract_details')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_password')->nullable();
            
            // Service fields (repeater)
            $table->json('service_description')->nullable();
            $table->json('service_quantity')->nullable();
            $table->json('service_rate')->nullable();
            $table->json('service_total')->nullable();
            $table->decimal('service_contract_amount', 12, 2)->default(0);
            
            // AMC and project fields
            $table->date('amc_start_date')->nullable();
            $table->decimal('amc_amount', 12, 2)->nullable();
            $table->date('project_start_date')->nullable();
            $table->string('completion_time')->nullable();
            $table->string('retention_time')->nullable();
            $table->decimal('retention_amount', 12, 2)->nullable();
            $table->decimal('retention_percent', 5, 2)->nullable();
            $table->date('tentative_complete_date')->nullable();
            
            // Terms fields (repeater)
            $table->json('terms_description')->nullable();
            $table->json('terms_quantity')->nullable();
            $table->json('terms_rate')->nullable();
            $table->json('terms_total')->nullable();
            $table->json('terms_completion')->nullable();
            $table->json('completion_terms')->nullable();
            $table->date('terms_tentative_complete_date')->nullable();
            $table->json('custom_terms_and_conditions')->nullable();
            
            // Footer fields
            $table->string('prepared_by')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('own_company_name')->nullable();
            
            // Feature boolean fields
            $table->boolean('sample_management')->default(false);
            $table->boolean('user_friendly_interface')->default(false);
            $table->boolean('contact_management')->default(false);
            $table->boolean('test_management')->default(false);
            $table->boolean('employee_management')->default(false);
            $table->boolean('lead_opportunity_management')->default(false);
            $table->boolean('data_integrity_security')->default(false);
            $table->boolean('recruitment_onboarding')->default(false);
            $table->boolean('sales_automation')->default(false);
            $table->boolean('reporting_analytics')->default(false);
            $table->boolean('payroll_management')->default(false);
            $table->boolean('customer_service_management')->default(false);
            $table->boolean('inventory_management')->default(false);
            $table->boolean('training_development')->default(false);
            $table->boolean('integration_lab')->default(false);
            $table->boolean('employee_self_service_portal')->default(false);
            $table->boolean('marketing_automation')->default(false);
            $table->boolean('regulatory_compliance')->default(false);
            $table->boolean('analytics_reporting')->default(false);
            $table->boolean('integration_crm')->default(false);
            $table->boolean('workflow_automation')->default(false);
            $table->boolean('integration_hr')->default(false);
            
            // Basic cost fields (repeater)
            $table->json('basic_cost_description')->nullable();
            $table->json('basic_cost_quantity')->nullable();
            $table->json('basic_cost_rate')->nullable();
            $table->json('basic_cost_total')->nullable();
            $table->decimal('basic_cost_total_amount', 12, 2)->default(0);
            
            // Additional cost fields (repeater)
            $table->json('additional_cost_description')->nullable();
            $table->json('additional_cost_quantity')->nullable();
            $table->json('additional_cost_rate')->nullable();
            $table->json('additional_cost_total')->nullable();
            $table->decimal('additional_cost_total_amount', 12, 2)->default(0);
            
            // Support fields (repeater)
            $table->json('support_description')->nullable();
            $table->json('support_quantity')->nullable();
            $table->json('support_rate')->nullable();
            $table->json('support_total')->nullable();
            $table->decimal('support_total_amount', 12, 2)->default(0);
            
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('inquiry_id')->references('id')->on('inquiries')->onDelete('set null');
            $table->foreign('customer_id')->references('id')->on('companies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};