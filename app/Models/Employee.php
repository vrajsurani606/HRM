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
        'email',
        'mobile_no',
        'address',
        'position',
        'password_hash',
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
     * Get all of the letters for the employee.
     */
    public function letters(): HasMany
    {
        return $this->hasMany(EmployeeLetter::class);
    }

    /**
     * Get the digital card for the employee.
     */
    public function digitalCard()
    {
        return $this->hasOne(DigitalCard::class);
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
}
