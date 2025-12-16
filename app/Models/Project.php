<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'company_id', 'stage_id', 'position', 'start_date', 'due_date', 'priority', 'status', 'total_tasks', 'completed_tasks', 'budget'];

    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
    ];

    public function stage()
    {
        return $this->belongsTo(ProjectStage::class, 'stage_id');
    }

    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class, 'company_id');
    }

    public function getProgressAttribute()
    {
        return $this->total_tasks > 0 ? round(($this->completed_tasks / $this->total_tasks) * 100) : 0;
    }

    public function tasks()
    {
        return $this->hasMany(ProjectTask::class)->whereNull('parent_id')->orderBy('order');
    }

    public function allTasks()
    {
        return $this->hasMany(ProjectTask::class);
    }

    public function comments()
    {
        return $this->hasMany(ProjectComment::class)->with('user')->orderBy('created_at', 'asc');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members')->withPivot('role')->withTimestamps();
    }

    public function projectMaterials()
    {
        return $this->hasMany(ProjectMaterial::class);
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'project_materials')
            ->withPivot('material_report_id', 'is_completed')
            ->withTimestamps();
    }
}