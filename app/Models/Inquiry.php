<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_code',
        'inquiry_date',
        'company_name',
        'company_address',
        'industry_type',
        'email',
        'company_phone',
        'city',
        'city_other',
        'state',
        'state_other',
        'contact_mobile',
        'contact_name',
        'scope_link',
        'contact_position',
        'quotation_file',
        'quotation_sent',
    ];

    protected $casts = [
        'inquiry_date' => 'date',
    ];

    public function followUps()
    {
        return $this->hasMany(\App\Models\InquiryFollowUp::class);
    }
}