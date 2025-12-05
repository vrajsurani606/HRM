<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Note extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'priority',
        'status',
        'type',
        'due_date',
        'created_by',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who created the note
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user assigned to the note
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get employees assigned to this note
     */
    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'note_employee', 'note_id', 'employee_id')
            ->withTimestamps()
            ->withPivot('read_at', 'acknowledged_at');
    }

    /**
     * Get note replies/comments
     */
    public function replies()
    {
        return $this->hasMany(NoteReply::class)->orderBy('created_at', 'desc');
    }

    /**
     * Scope: Get notes for admin
     */
    public function scopeForAdmin($query)
    {
        return $query->where('type', 'admin')->orWhere('created_by', auth()->id());
    }

    /**
     * Scope: Get notes for employee
     */
    public function scopeForEmployee($query)
    {
        $employee = Employee::where('user_id', auth()->id())->first();
        if ($employee) {
            return $query->whereHas('employees', function ($q) use ($employee) {
                $q->where('employee_id', $employee->id);
            });
        }
        return $query->whereNull('id');
    }

    /**
     * Scope: Get unread notes
     */
    public function scopeUnread($query)
    {
        return $query->whereHas('employees', function ($q) {
            $q->whereNull('read_at');
        });
    }

    /**
     * Mark note as read by employee
     */
    public function markAsRead($employeeId)
    {
        $this->employees()->updateExistingPivot($employeeId, [
            'read_at' => now(),
        ]);
    }

    /**
     * Mark note as acknowledged by employee
     */
    public function markAsAcknowledged($employeeId)
    {
        $this->employees()->updateExistingPivot($employeeId, [
            'acknowledged_at' => now(),
        ]);
    }

    /**
     * Check if note is overdue
     */
    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() && $this->status !== 'completed';
    }

    /**
     * Get status badge color
     */
    public function getStatusColor(): string
    {
        return match($this->status) {
            'pending' => '#fbbf24',
            'in_progress' => '#3b82f6',
            'completed' => '#10b981',
            'urgent' => '#ef4444',
            default => '#6b7280',
        };
    }

    /**
     * Get priority badge color
     */
    public function getPriorityColor(): string
    {
        return match($this->priority) {
            'low' => '#10b981',
            'medium' => '#f59e0b',
            'high' => '#ef4444',
            'urgent' => '#7c3aed',
            default => '#6b7280',
        };
    }
}
