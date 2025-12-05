<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'document_name',
        'document_type',
        'file_path',
        'file_type',
        'file_size',
        'description',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getFileSizeHumanAttribute()
    {
        if (!$this->file_size) return 'Unknown';
        
        $size = $this->file_size;
        if ($size >= 1048576) {
            return round($size / 1048576, 2) . ' MB';
        } elseif ($size >= 1024) {
            return round($size / 1024, 2) . ' KB';
        }
        return $size . ' B';
    }
}
