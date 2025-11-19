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
        'um_id',
        'full_name',
        'current_position',
        'company_name',
        'years_of_experience',
        'experience_years',
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
        'willing_to',
        'previous_roles',
        'education',
        'certifications',
        'gallery',
        'achievements',
        'languages',
        'projects',
        'resume_path',
        'resume',
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

    // Accessors for backward compatibility
    public function getSkillsArrayAttribute()
    {
        return !empty($this->skills) ? array_map('trim', explode(',', $this->skills)) : [];
    }

    public function getHobbiesArrayAttribute()
    {
        return !empty($this->hobbies) ? array_map('trim', explode(',', $this->hobbies)) : [];
    }

    public function getSocialsAttribute()
    {
        return [
            'linkedin' => $this->linkedin ?? '',
            'github' => $this->github ?? '',
            'twitter' => $this->twitter ?? '',
            'instagram' => $this->instagram ?? '',
            'facebook' => $this->facebook ?? '',
            'portfolio' => $this->portfolio ?? ''
        ];
    }

    public function getProfileAttribute()
    {
        return [
            'name' => $this->full_name ?: '',
            'position' => $this->current_position ?: '',
            'company' => $this->company_name ?: '',
            'email' => $this->email ?? '',
            'phone' => $this->phone ?? '',
            'location' => $this->location ?? '',
            'summary' => $this->summary ?? '',
            'experience_years' => $this->experience_years ?: '',
            'willing_to' => $this->willing_to ?? ''
        ];
    }

    public function getProfileImageAttribute()
    {
        $gallery = $this->gallery;
        return (!empty($gallery) && is_array($gallery) && file_exists(public_path($gallery[0]))) 
            ? $gallery[0] : 'blank_user.webp';
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    // Scope for finding by um_id or id
    public function scopeFindByIdentifier($query, $identifier)
    {
        if (is_numeric($identifier)) {
            return $query->where('um_id', $identifier)->orWhere('id', $identifier);
        }
        return $query->where('id', $identifier);
    }
}