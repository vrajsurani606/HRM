<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_code',
        'rec_date',
        'company_name',
        'total_amount',
        'paid_amount',
        'remain_amount',
        'received_amount',
        'payment_type',
        'narration',
        'trans_code',
    ];

    protected $casts = [
        'rec_date' => 'date',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'remain_amount' => 'decimal:2',
        'received_amount' => 'decimal:2',
    ];
}