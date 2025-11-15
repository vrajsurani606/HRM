<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'check_in',
        'check_out',
        'total_working_hours',
        'status',
        'notes',
        'check_in_ip',
        'check_out_ip',
        'check_in_location',
        'check_out_location',
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function calculateWorkingHours(): ?string
    {
        if ($this->check_in && $this->check_out) {
            $checkIn = \Carbon\Carbon::parse($this->check_in);
            $checkOut = \Carbon\Carbon::parse($this->check_out);
            
            // Calculate total minutes
            $totalMinutes = $checkIn->diffInMinutes($checkOut);
            
            // Convert to hours and minutes (e.g., 8:30 for 8 hours and 30 minutes)
            $hours = floor($totalMinutes / 60);
            $minutes = $totalMinutes % 60;
            
            return sprintf('%02d:%02d:00', $hours, $minutes);
        }
        
        return null;
    }
}
