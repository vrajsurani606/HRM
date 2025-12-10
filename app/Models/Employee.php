<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'gender',
        'date_of_birth',
        'marital_status',
        'mother_name',
        'mother_mobile_no',
        'father_name',
        'father_mobile_no',
        'email',
        'mobile_no',
        'address',
        'position',
        'password_hash',
        'plain_password',
        'reference_name',
        'reference_no',
        'aadhaar_no',
        'pan_no',
        'highest_qualification',
        'year_of_passing',
        'aadhaar_photo_front',
        'aadhaar_photo_back',
        'pan_photo',
        'bank_name',
        'bank_account_no',
        'bank_ifsc',
        'cheque_photo',
        'marksheet_photo',
        'photo_path',
        'experience_type',
        'previous_company_name',
        'previous_designation',
        'duration',
        'reason_for_leaving',
        'previous_salary',
        'current_offer_amount',
        'has_incentive',
        'incentive_amount',
        'joining_date',
        'role_id',
        'status',
        'user_id',
    ];

    protected $casts = [
        'previous_salary' => 'decimal:2',
        'current_offer_amount' => 'decimal:2',
        'has_incentive' => 'boolean',
        'incentive_amount' => 'decimal:2',
        'joining_date' => 'date',
        'date_of_birth' => 'date',
    ];

    public function socials(){ return $this->hasOne(EmployeeSocial::class); }
    public function languages(){ return $this->hasMany(EmployeeLanguage::class); }
    public function previousRoles(){ return $this->hasMany(EmployeePreviousRole::class); }
    public function educations(){ return $this->hasMany(EmployeeEducation::class); }
    public function certifications(){ return $this->hasMany(EmployeeCertification::class); }
    public function achievements(){ return $this->hasMany(EmployeeAchievement::class); }
    public function projects(){ return $this->hasMany(EmployeeProject::class); }
    public function profileImages(){ return $this->hasMany(EmployeeProfileImage::class); }
    
    /**
     * Get all leaves for the employee.
     */
    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }
    
    /**
     * Get leave balances for the employee.
     */
    public function leaveBalances()
    {
        return $this->hasMany(LeaveBalance::class);
    }
    
    /**
     * Get current year leave balance.
     */
    public function currentLeaveBalance()
    {
        return $this->hasOne(LeaveBalance::class)->where('year', now()->year);
    }
    
    /**
     * Get all of the letters for the employee.
     */
    public function letters(): HasMany
    {
        return $this->hasMany(EmployeeLetter::class);
    }

    /**
     * Get all payroll records for the employee.
     */
    public function payrolls(): HasMany
    {
        return $this->hasMany(Payroll::class);
    }

    /**
     * Get the digital card for the employee.
     */
    public function digitalCard()
    {
        return $this->hasOne(DigitalCard::class);
    }
    
    /**
     * Get the user account for the employee.
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Get all notes assigned to this employee
     */
    public function notes()
    {
        return $this->belongsToMany(Note::class, 'note_employee', 'employee_id', 'note_id')
            ->withTimestamps()
            ->withPivot('read_at', 'acknowledged_at')
            ->orderBy('created_at', 'desc');
    }

    public static function nextCode(string $prefix = 'CMS/EMP/'): string
    {
        $last = static::where('code', 'like', $prefix.'%')->orderByDesc('id')->value('code');
        $nextNumber = 1;
        if ($last) {
            $parts = explode('/', $last);
            $lastNum = intval(end($parts));
            $nextNumber = $lastNum + 1;
        }
        return $prefix . str_pad((string)$nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Set the PAN number attribute (always uppercase).
     */
    public function setPanNoAttribute($value)
    {
        $this->attributes['pan_no'] = !empty($value) ? strtoupper($value) : null;
    }

    /**
     * Get all custom documents for the employee.
     */
    public function documents()
    {
        return $this->hasMany(EmployeeDocument::class);
    }
}
