<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferLetter extends Model
{
    use HasFactory;

    protected $fillable = [
            'hiring_lead_id',
            'issue_date',
            'note',
            'monthly_salary',
            'annual_ctc',
            'reporting_manager',
            'working_hours',
            'date_of_joining',
            'probation_period',
            'salary_increment',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'date_of_joining' => 'date',
        'monthly_salary' => 'decimal:2',
        'annual_ctc' => 'decimal:2',
    ];

    public function lead()
    {
        return $this->belongsTo(HiringLead::class, 'hiring_lead_id');
    }
}
