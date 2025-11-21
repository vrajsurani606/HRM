<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'unique_code',
        'proforma_date',
        'company_name',
        'bill_no',
        'address',
        'gst_no',
        'mobile_no',
        'description',
        'sac_code',
        'quantity',
        'rate',
        'total',
        'sub_total',
        'discount_percent',
        'discount_amount',
        'cgst_percent',
        'cgst_amount',
        'sgst_percent',
        'sgst_amount',
        'igst_percent',
        'igst_amount',
        'final_amount',
        'total_tax_amount',
        'billing_item',
        'type_of_billing',
        'tds_amount',
        'remark',
    ];

    protected $casts = [
        'proforma_date' => 'date',
        'description' => 'array',
        'sac_code' => 'array',
        'quantity' => 'array',
        'rate' => 'array',
        'total' => 'array',
        'sub_total' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'cgst_percent' => 'decimal:2',
        'cgst_amount' => 'decimal:2',
        'sgst_percent' => 'decimal:2',
        'sgst_amount' => 'decimal:2',
        'igst_percent' => 'decimal:2',
        'igst_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'total_tax_amount' => 'decimal:2',
        'billing_item' => 'decimal:2',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}
