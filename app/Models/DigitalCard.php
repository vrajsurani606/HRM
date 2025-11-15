<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DigitalCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'full_name',
        'current_position',
        'company_name',
        'years_experience',
        'email',
        'phone',
        'linkedin',
        'portfolio',
        'facebook',
        'twitter',
        'instagram',
        'github',
        'location',
        'skills',
        'hobbies',
        'summary',
        'roles',
        'education',
        'certifications',
        'gallery',
        'achievements',
        'languages',
        'projects',
        'resume_path',
    ];

    protected $casts = [
        'roles' => 'array',
        'education' => 'array',
        'certifications' => 'array',
        'gallery' => 'array',
        'achievements' => 'array',
        'languages' => 'array',
        'projects' => 'array',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}