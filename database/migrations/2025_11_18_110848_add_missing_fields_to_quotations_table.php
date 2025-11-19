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
            // Contact Person 2 fields - only add if they don't exist
            if (!Schema::hasColumn('quotations', 'contact_person_2')) {
                $table->string('contact_person_2')->nullable();
            }
            if (!Schema::hasColumn('quotations', 'contact_number_2')) {
                $table->string('contact_number_2')->nullable();
            }
            if (!Schema::hasColumn('quotations', 'position_2')) {
                $table->string('position_2')->nullable();
            }
            
            // Additional contact fields
            if (!Schema::hasColumn('quotations', 'contact_person_3')) {
                $table->string('contact_person_3')->nullable();
            }
            if (!Schema::hasColumn('quotations', 'contact_number_3')) {
                $table->string('contact_number_3')->nullable();
            }
            if (!Schema::hasColumn('quotations', 'position_3')) {
                $table->string('position_3')->nullable();
            }
            
            // Cost calculation fields
            if (!Schema::hasColumn('quotations', 'basic_subtotal')) {
                $table->decimal('basic_subtotal', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('quotations', 'basic_gst_percentage')) {
                $table->decimal('basic_gst_percentage', 5, 2)->default(0);
            }
            if (!Schema::hasColumn('quotations', 'basic_gst_amount')) {
                $table->decimal('basic_gst_amount', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('quotations', 'basic_total')) {
                $table->decimal('basic_total', 12, 2)->default(0);
            }
            
            if (!Schema::hasColumn('quotations', 'additional_subtotal')) {
                $table->decimal('additional_subtotal', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('quotations', 'additional_gst_percentage')) {
                $table->decimal('additional_gst_percentage', 5, 2)->default(0);
            }
            if (!Schema::hasColumn('quotations', 'additional_gst_amount')) {
                $table->decimal('additional_gst_amount', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('quotations', 'additional_total')) {
                $table->decimal('additional_total', 12, 2)->default(0);
            }
            
            if (!Schema::hasColumn('quotations', 'maintenance_subtotal')) {
                $table->decimal('maintenance_subtotal', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('quotations', 'maintenance_gst_percentage')) {
                $table->decimal('maintenance_gst_percentage', 5, 2)->default(0);
            }
            if (!Schema::hasColumn('quotations', 'maintenance_gst_amount')) {
                $table->decimal('maintenance_gst_amount', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('quotations', 'maintenance_total')) {
                $table->decimal('maintenance_total', 12, 2)->default(0);
            }
            
            // Totals
            if (!Schema::hasColumn('quotations', 'subtotal')) {
                $table->decimal('subtotal', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('quotations', 'total_gst_amount')) {
                $table->decimal('total_gst_amount', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('quotations', 'grand_total')) {
                $table->decimal('grand_total', 12, 2)->default(0);
            }
            
            // Terms and conditions
            if (!Schema::hasColumn('quotations', 'terms_conditions')) {
                $table->text('terms_conditions')->nullable();
            }
            if (!Schema::hasColumn('quotations', 'payment_terms')) {
                $table->text('payment_terms')->nullable();
            }
            if (!Schema::hasColumn('quotations', 'delivery_terms')) {
                $table->text('delivery_terms')->nullable();
            }
            
            // Additional fields from form
            if (!Schema::hasColumn('quotations', 'selected_features')) {
                $table->json('selected_features')->nullable()->comment('Selected features from the premium section');
            }
            if (!Schema::hasColumn('quotations', 'amc_frequency')) {
                $table->string('amc_frequency')->nullable()->comment('AMC frequency (monthly, quarterly, yearly)');
            }
            if (!Schema::hasColumn('quotations', 'payment_plan')) {
                $table->string('payment_plan')->nullable()->comment('Payment plan details');
            }
            
            // Status tracking
            if (!Schema::hasColumn('quotations', 'approval_status')) {
                $table->string('approval_status')->default('draft')->comment('draft, pending, approved, rejected');
            }
            if (!Schema::hasColumn('quotations', 'approved_at')) {
                $table->dateTime('approved_at')->nullable();
            }
            if (!Schema::hasColumn('quotations', 'approved_by')) {
                $table->unsignedBigInteger('approved_by')->nullable();
            }
            if (!Schema::hasColumn('quotations', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            // Drop columns that exist
            $columnsToCheck = [
                'contact_person_2', 'contact_number_2', 'position_2',
                'contact_person_3', 'contact_number_3', 'position_3',
                'basic_subtotal', 'basic_gst_percentage', 'basic_gst_amount', 'basic_total',
                'additional_subtotal', 'additional_gst_percentage', 'additional_gst_amount', 'additional_total',
                'maintenance_subtotal', 'maintenance_gst_percentage', 'maintenance_gst_amount', 'maintenance_total',
                'subtotal', 'total_gst_amount', 'grand_total',
                'terms_conditions', 'payment_terms', 'delivery_terms',
                'selected_features', 'amc_frequency', 'payment_plan',
                'approval_status', 'approved_at', 'approved_by', 'rejection_reason'
            ];
            
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('quotations', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
