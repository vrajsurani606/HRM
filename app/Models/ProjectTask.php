<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
    protected $fillable = [
        'project_id',
        'parent_id',
        'title',
        'description',
        'assigned_to',
        'due_date',
        'due_time',
        'is_completed',
        'order'
    ];

    protected $casts = [
        'due_date' => 'date',
        'is_completed' => 'boolean'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function parent()
    {
        return $this->belongsTo(ProjectTask::class, 'parent_id');
    }

    public function subtasks()
    {
        return $this->hasMany(ProjectTask::class, 'parent_id')->orderBy('order');
    }

    public function assignedEmployee()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'assigned_to');
    }
}
