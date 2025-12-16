<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_code',
        'receipt_date',
        'company_name',
        'invoice_type',
        'invoice_ids',
        'partial_amounts',
        'received_amount',
        'payment_type',
        'narration',
        'trans_code',
    ];

    protected $casts = [
        'receipt_date' => 'date',
        'invoice_ids' => 'array',
        'partial_amounts' => 'array',
        'received_amount' => 'decimal:2',
    ];

    public function invoices()
    {
        if (empty($this->invoice_ids)) {
            return collect();
        }
        return Invoice::whereIn('id', $this->invoice_ids)->get();
    }
}
