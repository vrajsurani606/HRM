<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    // Status constants
    const STATUS_OPEN = 'open';
    const STATUS_ASSIGNED = 'assigned';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_RESOLVED = 'resolved';
    const STATUS_CLOSED = 'closed';

    protected $fillable = [
        'ticket_no',
        'subject',
        'status',
        'priority',
        'assigned_to',
        'opened_by',
        'opened_at',
        'category',
        'customer',
        'title',
        'description',
        'attachment',
        'attachments',
        'company',
        'company_id',
        'ticket_type',
        'project_id',
        'completed_at',
        'completed_by',
        'confirmed_at',
        'confirmed_by',
        'resolution_notes',
        'completion_images',
        'closed_at',
        'closed_by',
        'customer_feedback',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'completed_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'closed_at' => 'datetime',
        'completion_images' => 'array',
        'attachments' => 'array',
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
    
    /**
     * Get the project associated with this ticket.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    
    /**
     * Get the company associated with this ticket.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
    /**
     * Get the employee who completed this ticket.
     */
    public function completedBy()
    {
        return $this->belongsTo(Employee::class, 'completed_by');
    }
    
    /**
     * Get the user who confirmed this ticket.
     */
    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }
    
    /**
     * Get the user who closed this ticket.
     */
    public function closedBy()
    {
        return $this->belongsTo(User::class, 'closed_by');
    }
    
    /**
     * Check if ticket can be assigned
     */
    public function canBeAssigned()
    {
        return in_array($this->status, [self::STATUS_OPEN]);
    }
    
    /**
     * Check if ticket can be closed by customer
     */
    public function canBeClosed()
    {
        return in_array($this->status, [self::STATUS_OPEN, self::STATUS_RESOLVED]);
    }
    
    /**
     * Check if ticket can be completed by employee
     */
    public function canBeCompleted()
    {
        return in_array($this->status, [self::STATUS_ASSIGNED, self::STATUS_IN_PROGRESS]);
    }
    
    /**
     * Check if ticket can be confirmed by admin
     */
    public function canBeConfirmed()
    {
        return $this->status === self::STATUS_COMPLETED;
    }
}
