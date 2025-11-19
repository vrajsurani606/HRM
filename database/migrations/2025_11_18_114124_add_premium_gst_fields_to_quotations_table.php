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
            // Premium quotation GST calculation fields
            if (!Schema::hasColumn('quotations', 'basic_gst_rate')) {
                $table->decimal('basic_gst_rate', 5, 2)->default(18.00)->comment('GST rate for basic cost');
            }
            if (!Schema::hasColumn('quotations', 'additional_gst_rate')) {
                $table->decimal('additional_gst_rate', 5, 2)->default(18.00)->comment('GST rate for additional cost');
            }
            if (!Schema::hasColumn('quotations', 'maintenance_gst_rate')) {
                $table->decimal('maintenance_gst_rate', 5, 2)->default(18.00)->comment('GST rate for maintenance cost');
            }
            
            // Final calculation fields
            if (!Schema::hasColumn('quotations', 'total_basic_amount')) {
                $table->decimal('total_basic_amount', 12, 2)->default(0)->comment('Basic cost + GST');
            }
            if (!Schema::hasColumn('quotations', 'total_additional_amount')) {
                $table->decimal('total_additional_amount', 12, 2)->default(0)->comment('Additional cost + GST');
            }
            if (!Schema::hasColumn('quotations', 'total_maintenance_amount')) {
                $table->decimal('total_maintenance_amount', 12, 2)->default(0)->comment('Maintenance cost + GST');
            }
            if (!Schema::hasColumn('quotations', 'final_total_amount')) {
                $table->decimal('final_total_amount', 12, 2)->default(0)->comment('Sum of all costs with GST');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $columnsToCheck = [
                'basic_gst_rate', 'additional_gst_rate', 'maintenance_gst_rate',
                'total_basic_amount', 'total_additional_amount', 'total_maintenance_amount',
                'final_total_amount'
            ];
            
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('quotations', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};