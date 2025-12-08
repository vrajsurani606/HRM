<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_no',
        'subject',
        'status',
        'priority',
        'assigned_to',
        'opened_by',
        'opened_at',
        'work_status',
        'category',
        'customer',
        'title',
        'description',
        'company',
        'ticket_type',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
    ];

    /**
     * Get the employee assigned to this ticket.
     */
    public function assignedEmployee()
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }

    /**
     * Alias for assignedEmployee (for backward compatibility)
     */
    public function assignedTo()
    {
        return $this->assignedEmployee();
    }

    /**
     * Get the user who opened this ticket.
     */
    public function opener()
    {
        return $this->belongsTo(User::class, 'opened_by');
    }

    /**
     * Get all comments for this ticket.
     */
    public function comments()
    {
        return $this->hasMany(TicketComment::class)->orderBy('created_at', 'asc');
    }
}
