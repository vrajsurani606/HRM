<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    /**
     * Available chat colors for users
     */
    public static $chatColors = [
        '#6366f1', '#10b981', '#f59e0b', '#ec4899', '#8b5cf6', 
        '#ef4444', '#06b6d4', '#84cc16', '#f97316', '#14b8a6',
        '#a855f7', '#3b82f6', '#eab308', '#e11d48', '#0ea5e9'
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'plain_password',
        'mobile_no',
        'address',
        'photo_path',
        'company_id',
        'chat_color',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
        
        // Auto-assign chat color when creating new user
        static::creating(function ($user) {
            if (empty($user->chat_color)) {
                $user->chat_color = self::$chatColors[rand(0, count(self::$chatColors) - 1)];
            }
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the employee record associated with the user.
     */
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    /**
     * Get the company associated with the user.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the profile photo URL with fallback
     */
    public function getProfilePhotoUrlAttribute()
    {
        return get_profile_photo($this, $this->name);
    }

    /**
     * Get user initials
     */
    public function getInitialsAttribute()
    {
        return get_user_initials($this->name);
    }
}
