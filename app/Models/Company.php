<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    protected $fillable = [
        'unique_code', 'company_name', 'gst_no', 'pan_no', 'company_address',
        'state', 'city', 'contact_person_name', 'contact_person_mobile',
        'contact_person_position', 'company_email', 'company_phone', 
        'company_type', 'other_details', 'company_logo', 'scope_link',
        'sop_upload', 'quotation_upload', 'person_name_1', 'person_number_1',
        'person_position_1', 'person_name_2', 'person_number_2', 'person_position_2',
        'person_name_3', 'person_number_3', 'person_position_3', 'company_password',
        'company_employee_email', 'company_employee_password'
    ];
    
    protected $hidden = [
        'company_password', 'company_employee_password'
    ];
    
    protected $appends = ['logo_url', 'sop_url', 'quotation_url'];
    
    /**
     * Get the URL for the company logo
     */
    public function getLogoUrlAttribute()
    {
        if (!$this->company_logo) {
            return null;
        }
        
        // Check if it's already a full URL
        if (filter_var($this->company_logo, FILTER_VALIDATE_URL)) {
            return $this->company_logo;
        }
        
        $path = 'public/' . ltrim($this->company_logo, '/');
        return Storage::disk('public')->exists($path) 
            ? asset('storage/' . ltrim($this->company_logo, '/'))
            : null;
    }
    
    /**
     * Get the URL for the SOP document
     */
    public function getSopUrlAttribute()
    {
        if (!$this->sop_upload) {
            return null;
        }
        
        // Check if it's already a full URL
        if (filter_var($this->sop_upload, FILTER_VALIDATE_URL)) {
            return $this->sop_upload;
        }
        
        $path = 'public/' . ltrim($this->sop_upload, '/');
        return Storage::disk('public')->exists($path)
            ? route('company.documents.view', ['type' => 'sop', 'filename' => basename($this->sop_upload)])
            : null;
    }
    
    /**
     * Get the URL for the quotation document
     */
    public function getQuotationUrlAttribute()
    {
        if (!$this->quotation_upload) {
            return null;
        }
        
        // Check if it's already a full URL
        if (filter_var($this->quotation_upload, FILTER_VALIDATE_URL)) {
            return $this->quotation_upload;
        }
        
        $path = 'public/' . ltrim($this->quotation_upload, '/');
        return Storage::disk('public')->exists($path)
            ? route('company.documents.view', ['type' => 'quotation', 'filename' => basename($this->quotation_upload)])
            : null;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->unique_code)) {
                $latestCompany = self::latest('id')->first();
                $nextId = $latestCompany ? $latestCompany->id + 1 : 1;
                $model->unique_code = 'CMS/COM/' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
            }
            
            // Hash the company password if it's being set
            if ($model->company_password) {
                $model->company_password = bcrypt($model->company_password);
            }
            
            // Hash the employee password if it's being set
            if ($model->company_employee_password) {
                $model->company_employee_password = bcrypt($model->company_employee_password);
            }
        });
        
        static::updating(function ($model) {
            // Only update the password if a new one is provided
            if ($model->isDirty('company_password') && $model->company_password) {
                $model->company_password = bcrypt($model->company_password);
            }
            
            // Only update the employee password if a new one is provided
            if ($model->isDirty('company_employee_password') && $model->company_employee_password) {
                $model->company_employee_password = bcrypt($model->company_employee_password);
            }
        });
    }

    /**
     * Get the route key name for Laravel's route model binding.
     *
     * @return string
     */
    // Default route key name is 'id'
}
