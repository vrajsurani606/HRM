<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeLetter extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'reference_number',
        'title',
        'subject',
        'content',
        'type',
        'issue_date',
        'notes',
        'created_by',
        'monthly_salary',
        'annual_ctc',
        'reporting_manager',
        'working_hours',
        'date_of_joining',
        'probation_period',
        'salary_increment',
        'start_date',
        'end_date',
        'increment_amount',
        'increment_effective_date',
        'internship_position',
        'internship_start_date',
        'internship_end_date',
        'internship_address',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'issue_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'date_of_joining' => 'date',
        'increment_effective_date' => 'date',
        'internship_start_date' => 'date',
        'internship_end_date' => 'date',
    ];

    /**
     * Get the employee that owns the letter.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the user who created the letter.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    /**
     * Calculate duration between start and end dates
     */
    public function getDurationAttribute()
    {
        $startDate = \Carbon\Carbon::parse($this->start_date ?? $this->employee->joining_date);
        $endDate = \Carbon\Carbon::parse($this->end_date ?? now());
        
        $diff = $startDate->diff($endDate);
        $years = $diff->y;
        $months = $diff->m;
        $days = $diff->d;
        
        $duration = [];
        if ($years > 0) $duration[] = $years . ' year' . ($years > 1 ? 's' : '');
        if ($months > 0) $duration[] = $months . ' month' . ($months > 1 ? 's' : '');
        if ($days > 0) $duration[] = $days . ' day' . ($days > 1 ? 's' : '');
        
        return !empty($duration) ? implode(' ', $duration) : '0 days';
    }
}
