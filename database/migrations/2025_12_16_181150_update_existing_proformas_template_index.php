<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Proforma;
use App\Models\Quotation;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing proformas that don't have template_index set
        $proformas = Proforma::whereNull('template_index')
            ->whereNotNull('quotation_id')
            ->whereNotNull('type_of_billing')
            ->get();

        foreach ($proformas as $proforma) {
            $quotation = Quotation::find($proforma->quotation_id);
            if ($quotation && $quotation->terms_description) {
                // Find the template index based on type_of_billing
                foreach ($quotation->terms_description as $index => $description) {
                    if ($description === $proforma->type_of_billing) {
                        $proforma->update(['template_index' => $index]);
                        break; // Only update with the first match to avoid duplicates
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Set template_index back to null for proformas that were updated
        Proforma::whereNotNull('template_index')->update(['template_index' => null]);
    }
};