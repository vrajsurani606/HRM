<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyDocument extends Model
{
    protected $fillable = [
        'company_id',
        'document_name',
        'document_type',
        'file_path',
        'original_name',
        'file_size',
    ];

    protected $appends = ['file_url'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getFileUrlAttribute()
    {
        if (!$this->file_path) {
            return null;
        }

        return storage_asset($this->file_path);
    }

    public function isImage()
    {
        return in_array(strtolower($this->document_type), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    }
}
