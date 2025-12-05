<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NoteReply extends Model
{
    protected $fillable = [
        'note_id',
        'user_id',
        'content',
        'is_admin_reply',
    ];

    protected $casts = [
        'is_admin_reply' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the note this reply belongs to
     */
    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class);
    }

    /**
     * Get the user who created the reply
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
