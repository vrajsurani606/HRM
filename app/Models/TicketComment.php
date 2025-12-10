<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'comment',
        'is_internal',
        'attachment_path',
        'attachment_type',
        'attachment_name',
    ];

    protected $casts = [
        'is_internal' => 'boolean',
    ];
    
    /**
     * Get the full URL for the attachment
     */
    public function getAttachmentUrlAttribute()
    {
        if ($this->attachment_path) {
            return asset('public/storage/' . ltrim($this->attachment_path, '/'));
        }
        return null;
    }
    
    /**
     * Check if attachment is an image
     */
    public function isImage()
    {
        return in_array($this->attachment_type, ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp']);
    }
    
    /**
     * Check if attachment is a PDF
     */
    public function isPdf()
    {
        return $this->attachment_type === 'application/pdf';
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
