<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationFollowUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'followup_date',
        'next_followup_date',
        'demo_status',
        'scheduled_demo_date',
        'scheduled_demo_time',
        'demo_date',
        'demo_time',
        'remark',
        'quotation_note',
        'is_confirm',
    ];

    protected $casts = [
        'followup_date' => 'date',
        'next_followup_date' => 'date',
        'scheduled_demo_date' => 'date',
        'demo_date' => 'date',
        'is_confirm' => 'boolean',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}
