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
     * Available chat colors for users - expanded list for more uniqueness
     */
    public static $chatColors = [
        '#6366f1', '#10b981', '#f59e0b', '#ec4899', '#8b5cf6', 
        '#ef4444', '#06b6d4', '#84cc16', '#f97316', '#14b8a6',
        '#a855f7', '#3b82f6', '#eab308', '#e11d48', '#0ea5e9',
        '#7c3aed', '#059669', '#d97706', '#db2777', '#7c2d12',
        '#0891b2', '#65a30d', '#ea580c', '#0d9488', '#c026d3',
        '#2563eb', '#ca8a04', '#be123c', '#0284c7', '#4f46e5',
        '#16a34a', '#dc2626', '#9333ea', '#0369a1', '#15803d',
        '#b91c1c', '#7e22ce', '#1d4ed8', '#166534', '#991b1b'
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
        
        // Auto-assign unique chat color when creating new user
        static::creating(function ($user) {
            if (empty($user->chat_color)) {
                $user->chat_color = self::getUniqueColor();
            }
        });
    }

    /**
     * Get a unique color that is not already used by another user
     * If all colors are used, generate a random unique hex color
     */
    public static function getUniqueColor(): string
    {
        // Get all colors currently in use
        $usedColors = self::whereNotNull('chat_color')->pluck('chat_color')->toArray();
        
        // Find available colors from the predefined list
        $availableColors = array_diff(self::$chatColors, $usedColors);
        
        if (!empty($availableColors)) {
            // Return a random available color from predefined list
            return $availableColors[array_rand($availableColors)];
        }
        
        // All predefined colors are used, generate a unique random color
        $maxAttempts = 100;
        $attempts = 0;
        
        do {
            // Generate a random vibrant color (avoiding too light or too dark)
            $hue = rand(0, 360);
            $saturation = rand(60, 90); // Keep saturation high for vibrant colors
            $lightness = rand(40, 60);  // Keep lightness in middle range
            
            $color = self::hslToHex($hue, $saturation, $lightness);
            $attempts++;
        } while (in_array($color, $usedColors) && $attempts < $maxAttempts);
        
        return $color;
    }

    /**
     * Convert HSL to Hex color
     */
    private static function hslToHex(int $h, int $s, int $l): string
    {
        $s /= 100;
        $l /= 100;
        
        $c = (1 - abs(2 * $l - 1)) * $s;
        $x = $c * (1 - abs(fmod($h / 60, 2) - 1));
        $m = $l - $c / 2;
        
        if ($h < 60) {
            $r = $c; $g = $x; $b = 0;
        } elseif ($h < 120) {
            $r = $x; $g = $c; $b = 0;
        } elseif ($h < 180) {
            $r = 0; $g = $c; $b = $x;
        } elseif ($h < 240) {
            $r = 0; $g = $x; $b = $c;
        } elseif ($h < 300) {
            $r = $x; $g = 0; $b = $c;
        } else {
            $r = $c; $g = 0; $b = $x;
        }
        
        $r = round(($r + $m) * 255);
        $g = round(($g + $m) * 255);
        $b = round(($b + $m) * 255);
        
        return sprintf('#%02x%02x%02x', $r, $g, $b);
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
