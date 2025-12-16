<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'unique_code',
        'month',
        'year',
        'total_working_days',
        'attended_working_days',
        'taken_leave_casual',
        'taken_leave_sick',
        'medical_leave',
        'balance_leave_casual',
        'basic_salary',
        'hra',
        'dearness_allowance',
        'city_allowance',
        'medical_allowance',
        'tiffin_allowance',
        'assistant_allowance',
        'allowances',
        'bonuses',
        'pf',
        'professional_tax',
        'tds',
        'esic',
        'security_deposit',
        'leave_deduction',
        'leave_deduction_days',
        'deductions',
        'tax',
        'net_salary',
        'payment_date',
        'payment_method',
        'bank_name',
        'bank_account_no',
        'ifsc_code',
        'account_holder_name',
        'transaction_no',
        'payment_remarks',
        'status',
        'notes',
        'attachment',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'basic_salary' => 'decimal:2',
        'hra' => 'decimal:2',
        'dearness_allowance' => 'decimal:2',
        'city_allowance' => 'decimal:2',
        'medical_allowance' => 'decimal:2',
        'tiffin_allowance' => 'decimal:2',
        'assistant_allowance' => 'decimal:2',
        'allowances' => 'decimal:2',
        'bonuses' => 'decimal:2',
        'pf' => 'decimal:2',
        'professional_tax' => 'decimal:2',
        'tds' => 'decimal:2',
        'esic' => 'decimal:2',
        'security_deposit' => 'decimal:2',
        'leave_deduction' => 'decimal:2',
        'deductions' => 'decimal:2',
        'tax' => 'decimal:2',
        'net_salary' => 'decimal:2',
    ];

    /**
     * Get the employee that owns the payroll.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Calculate net salary
     */
    public function calculateNetSalary()
    {
        $gross = $this->basic_salary + $this->allowances + $this->bonuses;
        $totalDeductions = ($this->pf ?? 0) + ($this->professional_tax ?? 0) + ($this->tds ?? 0) + 
                          ($this->esic ?? 0) + ($this->security_deposit ?? 0) + ($this->leave_deduction ?? 0) + 
                          ($this->deductions ?? 0) + ($this->tax ?? 0);
        $this->net_salary = $gross - $totalDeductions;
        return $this->net_salary;
    }
    
    /**
     * Get detailed allowances breakdown
     */
    public function getAllowancesBreakdown()
    {
        return [
            'hra' => $this->hra ?? 0,
            'medical_allowance' => $this->medical_allowance ?? 0,
            'city_allowance' => $this->city_allowance ?? 0,
            'tiffin_allowance' => $this->tiffin_allowance ?? 0,
            'assistant_allowance' => $this->assistant_allowance ?? 0,
            'dearness_allowance' => $this->dearness_allowance ?? 0,
        ];
    }
    
    /**
     * Get detailed deductions breakdown
     */
    public function getDeductionsBreakdown()
    {
        return [
            'pf' => $this->pf ?? 0,
            'professional_tax' => $this->professional_tax ?? 0,
            'tds' => $this->tds ?? 0,
            'esic' => $this->esic ?? 0,
            'security_deposit' => $this->security_deposit ?? 0,
            'leave_deduction' => $this->leave_deduction ?? 0,
        ];
    }
}
