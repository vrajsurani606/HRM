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
        'years_of_experience',
        'email',
        'phone',
        'linkedin_profile',
        'portfolio_website',
        'facebook',
        'twitter',
        'instagram',
        'github',
        'location',
        'skills',
        'hobbies_interests',
        'professional_summary',
        'previous_roles',
        'education',
        'certifications',
        'gallery',
        'achievements',
        'languages',
        'projects',
        'resume_path',
    ];

    protected $casts = [
        'previous_roles' => 'array',
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