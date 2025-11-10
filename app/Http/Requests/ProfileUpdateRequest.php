<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'mobile_no' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'aadhaar_no' => ['nullable', 'string', 'max:12', 'regex:/^[0-9]{12}$/'],
            'pan_no' => ['nullable', 'string', 'max:10', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'],
            'gender' => ['nullable', 'in:male,female,other'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'marital_status' => ['nullable', 'in:single,married,divorced,widowed'],
            'highest_qualification' => ['nullable', 'string', 'max:255'],
            'year_of_passing' => ['nullable', 'integer', 'min:1950', 'max:' . (date('Y') + 1)],
            'previous_company_name' => ['nullable', 'string', 'max:255'],
            'previous_designation' => ['nullable', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:100'],
            'reason_for_leaving' => ['nullable', 'string', 'max:500'],
        ];
    }
}
