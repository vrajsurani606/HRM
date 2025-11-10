<div class="hrp-form">
  <div style="margin-bottom: 28px;">
    <h2 style="font-size: 22px; font-weight: 800; color: #111; margin: 0 0 10px 0; line-height: 1.3; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
      {{ __('Personal Information') }}
    </h2>
    <p style="font-size: 14px; color: #6b7280; margin: 0; line-height: 1.6; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
      {{ __('Update your personal information and contact details.') }}
    </p>
  </div>

  <form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
  </form>

  <form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <!-- Full Name -->
    <div class="hrp-grid">
      <div class="hrp-col-6">
        <label class="hrp-label Mobile-No" for="name">{{ __('Full Name') }} : <span style="color: #ef4444;">*</span></label>
        <input type="text" id="name" name="name" class="Rectangle-29" 
               value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" 
               placeholder="{{ __('Enter your full name') }}" />
        @if($errors->get('name'))
          <div style="color: #ef4444; font-size: 13px; margin-top: 8px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            {{ $errors->first('name') }}
          </div>
        @endif
      </div>

      <div class="hrp-col-6">
        <label class="hrp-label Mobile-No" for="email">{{ __('Email ID') }} : <span style="color: #ef4444;">*</span></label>
        <input type="email" id="email" name="email" class="Rectangle-29" 
               value="{{ old('email', $user->email) }}" required autocomplete="username" 
               placeholder="{{ __('Enter your email address') }}" />
        @if($errors->get('email'))
          <div style="color: #ef4444; font-size: 13px; margin-top: 8px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            {{ $errors->first('email') }}
          </div>
        @endif

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
          <div style="margin-top: 12px;">
            <p style="font-size: 13px; color: #6b7280; margin: 0 0 8px 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
              {{ __('Your email address is unverified.') }}
              <button form="send-verification" type="button" style="color: #0ea5e9; text-decoration: underline; border: none; background: none; padding: 0; cursor: pointer; font-family: inherit;">
                {{ __('Click here to re-send the verification email.') }}
              </button>
            </p>
            @if (session('status') === 'verification-link-sent')
              <p style="margin: 0; font-weight: 600; font-size: 13px; color: #10b981; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
                {{ __('A new verification link has been sent to your email address.') }}
              </p>
            @endif
          </div>
        @endif
      </div>
    </div>

    <!-- Gender and Date of Birth -->
    <div class="hrp-grid" style="margin-top: 20px;">
      <div class="hrp-col-6">
        <label class="hrp-label Mobile-No" for="gender">{{ __('Gender') }} :</label>
        <div class="hrp-segment" style="margin-top: 8px;">
          <input type="radio" id="gender_male" name="gender" value="male" 
                 {{ old('gender', ($employee->gender ?? null) ?: ($user->gender ?? '')) === 'male' ? 'checked' : '' }} />
          <label for="gender_male">Male</label>
          <input type="radio" id="gender_female" name="gender" value="female" 
                 {{ old('gender', ($employee->gender ?? null) ?: ($user->gender ?? '')) === 'female' ? 'checked' : '' }} />
          <label for="gender_female">Female</label>
        </div>
        @if($errors->get('gender'))
          <div style="color: #ef4444; font-size: 13px; margin-top: 8px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            {{ $errors->first('gender') }}
          </div>
        @endif
      </div>

      <div class="hrp-col-6">
        <label class="hrp-label Mobile-No" for="date_of_birth">{{ __('Date of Birth') }} :</label>
        <input type="date" id="date_of_birth" name="date_of_birth" class="Rectangle-29" 
               value="{{ old('date_of_birth', isset($employee->date_of_birth) ? $employee->date_of_birth->format('Y-m-d') : '') }}" 
               placeholder="{{ __('DD/MM/YYYY') }}" />
        @if($errors->get('date_of_birth'))
          <div style="color: #ef4444; font-size: 13px; margin-top: 8px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            {{ $errors->first('date_of_birth') }}
          </div>
        @endif
      </div>
    </div>

    <!-- Mobile No and Marital Status -->
    <div class="hrp-grid" style="margin-top: 20px;">
      <div class="hrp-col-6">
        <label class="hrp-label Mobile-No" for="mobile_no">{{ __('Mobile No') }} :</label>
        <input type="text" id="mobile_no" name="mobile_no" class="Rectangle-29" 
               value="{{ old('mobile_no', ($employee->mobile_no ?? null) ?: ($user->mobile_no ?? '')) }}" 
               placeholder="{{ __('+91 9729724869') }}" maxlength="15" />
        @if($errors->get('mobile_no'))
          <div style="color: #ef4444; font-size: 13px; margin-top: 8px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            {{ $errors->first('mobile_no') }}
          </div>
        @endif
      </div>

      <div class="hrp-col-6">
        <label class="hrp-label Mobile-No" for="marital_status">{{ __('Marital Status') }} :</label>
        <select id="marital_status" name="marital_status" class="Rectangle-29 Rectangle-29-select">
          <option value="">{{ __('Select Marital Status') }}</option>
          <option value="single" {{ old('marital_status', $employee->marital_status ?? '') === 'single' ? 'selected' : '' }}>Single</option>
          <option value="married" {{ old('marital_status', $employee->marital_status ?? '') === 'married' ? 'selected' : '' }}>Married</option>
          <option value="divorced" {{ old('marital_status', $employee->marital_status ?? '') === 'divorced' ? 'selected' : '' }}>Divorced</option>
          <option value="widowed" {{ old('marital_status', $employee->marital_status ?? '') === 'widowed' ? 'selected' : '' }}>Widowed</option>
        </select>
        @if($errors->get('marital_status'))
          <div style="color: #ef4444; font-size: 13px; margin-top: 8px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            {{ $errors->first('marital_status') }}
          </div>
        @endif
      </div>
    </div>

    <!-- Address -->
    <div class="hrp-grid" style="margin-top: 20px;">
      <div class="hrp-col-12">
        <label class="hrp-label" for="address">{{ __('Address') }} :</label>
        <textarea id="address" name="address" class="Rectangle-29-textarea" 
                  placeholder="{{ __('Enter Your Address') }}">{{ old('address', ($employee->address ?? null) ?: ($user->address ?? '')) }}</textarea>
        @if($errors->get('address'))
          <div style="color: #ef4444; font-size: 13px; margin-top: 8px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            {{ $errors->first('address') }}
          </div>
        @endif
      </div>
    </div>

    <!-- Aadhaar and PAN -->
    <div class="hrp-grid" style="margin-top: 20px;">
      <div class="hrp-col-6">
        <label class="hrp-label Mobile-No" for="aadhaar_no">{{ __('Aadhaar Card Number') }} :</label>
        <input type="text" id="aadhaar_no" name="aadhaar_no" class="Rectangle-29" 
               value="{{ old('aadhaar_no', $employee->aadhaar_no ?? '') }}" 
               placeholder="{{ __('XXXX XXXX XXXX') }}" maxlength="12" pattern="[0-9]{12}" />
        @if($errors->get('aadhaar_no'))
          <div style="color: #ef4444; font-size: 13px; margin-top: 8px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            {{ $errors->first('aadhaar_no') }}
          </div>
        @endif
      </div>

      <div class="hrp-col-6">
        <label class="hrp-label Mobile-No" for="pan_no">{{ __('PAN Number') }} :</label>
        <input type="text" id="pan_no" name="pan_no" class="Rectangle-29" 
               value="{{ old('pan_no', $employee->pan_no ?? '') }}" 
               placeholder="{{ __('XXXXX0000X') }}" maxlength="10" 
               style="text-transform: uppercase;" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" />
        @if($errors->get('pan_no'))
          <div style="color: #ef4444; font-size: 13px; margin-top: 8px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            {{ $errors->first('pan_no') }}
          </div>
        @endif
      </div>
    </div>

    <!-- Highest Qualification and Year of Passing -->
    <div class="hrp-grid" style="margin-top: 20px;">
      <div class="hrp-col-6">
        <label class="hrp-label Mobile-No" for="highest_qualification">{{ __('Highest Qualification') }} :</label>
        <input type="text" id="highest_qualification" name="highest_qualification" class="Rectangle-29" 
               value="{{ old('highest_qualification', $employee->highest_qualification ?? '') }}" 
               placeholder="{{ __('Enter your Highest Qualification') }}" />
        @if($errors->get('highest_qualification'))
          <div style="color: #ef4444; font-size: 13px; margin-top: 8px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            {{ $errors->first('highest_qualification') }}
          </div>
        @endif
      </div>

      <div class="hrp-col-6">
        <label class="hrp-label Mobile-No" for="year_of_passing">{{ __('Year of Passing') }} :</label>
        <input type="number" id="year_of_passing" name="year_of_passing" class="Rectangle-29" 
               value="{{ old('year_of_passing', $employee->year_of_passing ?? '') }}" 
               placeholder="{{ __('Passing Year') }}" min="1950" max="{{ date('Y') + 1 }}" />
        @if($errors->get('year_of_passing'))
          <div style="color: #ef4444; font-size: 13px; margin-top: 8px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            {{ $errors->first('year_of_passing') }}
          </div>
        @endif
      </div>
    </div>

    <!-- Previous Company Name and Previous Designation -->
    <div class="hrp-grid" style="margin-top: 20px;">
      <div class="hrp-col-6">
        <label class="hrp-label Mobile-No" for="previous_company_name">{{ __('Previous Company Name') }} :</label>
        <input type="text" id="previous_company_name" name="previous_company_name" class="Rectangle-29" 
               value="{{ old('previous_company_name', $employee->previous_company_name ?? '') }}" 
               placeholder="{{ __('Enter your Last Company Name') }}" />
        @if($errors->get('previous_company_name'))
          <div style="color: #ef4444; font-size: 13px; margin-top: 8px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            {{ $errors->first('previous_company_name') }}
          </div>
        @endif
      </div>

      <div class="hrp-col-6">
        <label class="hrp-label Mobile-No" for="previous_designation">{{ __('Previous Designation') }} :</label>
        <input type="text" id="previous_designation" name="previous_designation" class="Rectangle-29" 
               value="{{ old('previous_designation', $employee->previous_designation ?? '') }}" 
               placeholder="{{ __('Enter your Last Designation') }}" />
        @if($errors->get('previous_designation'))
          <div style="color: #ef4444; font-size: 13px; margin-top: 8px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            {{ $errors->first('previous_designation') }}
          </div>
        @endif
      </div>
    </div>

    <!-- Duration and Reason for Leaving -->
    <div class="hrp-grid" style="margin-top: 20px;">
      <div class="hrp-col-6">
        <label class="hrp-label Mobile-No" for="duration">{{ __('Duration') }} :</label>
        <input type="text" id="duration" name="duration" class="Rectangle-29" 
               value="{{ old('duration', $employee->duration ?? '') }}" 
               placeholder="{{ __('Add Time Duration') }}" />
        @if($errors->get('duration'))
          <div style="color: #ef4444; font-size: 13px; margin-top: 8px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            {{ $errors->first('duration') }}
          </div>
        @endif
      </div>

      <div class="hrp-col-6">
        <label class="hrp-label Mobile-No" for="reason_for_leaving">{{ __('Reason for Leaving') }} :</label>
        <textarea id="reason_for_leaving" name="reason_for_leaving" class="Rectangle-29-textarea" 
                  placeholder="{{ __('Enter Reason for Leaving') }}">{{ old('reason_for_leaving', $employee->reason_for_leaving ?? '') }}</textarea>
        @if($errors->get('reason_for_leaving'))
          <div style="color: #ef4444; font-size: 13px; margin-top: 8px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            {{ $errors->first('reason_for_leaving') }}
          </div>
        @endif
      </div>
    </div>

    <!-- Readonly Fields -->
    <div class="hrp-grid" style="margin-top: 20px;">
      <div class="hrp-col-6">
        <label class="hrp-label Mobile-No" for="joining_date">{{ __('Joining Date') }} :</label>
        <input type="date" id="joining_date" name="joining_date" class="Rectangle-29" 
               value="{{ old('joining_date', isset($employee->joining_date) ? $employee->joining_date->format('Y-m-d') : '') }}" 
               readonly style="background: #f9fafb; cursor: not-allowed;" />
      </div>

      <div class="hrp-col-6">
        <label class="hrp-label Mobile-No" for="position">{{ __('Position') }} :</label>
        <input type="text" id="position" name="position" class="Rectangle-29" 
               value="{{ old('position', ($employee->position ?? $user->position) ?? '') }}" readonly 
               style="background: #f9fafb; cursor: not-allowed;" />
      </div>
    </div>

    <div class="hrp-actions" style="margin-top: 32px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
      <button type="submit" class="hrp-btn hrp-btn-primary" style="font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-weight: 800;">
        <i class="fa fa-save"></i> {{ __('SAVE') }}
      </button>

      @if (session('status') === 'profile-updated')
        <p style="color: #10b981; margin: 0 0 0 16px; font-size: 14px; font-weight: 600; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
          <i class="fa fa-check-circle"></i> {{ __('Saved successfully.') }}
        </p>
      @endif
    </div>
  </form>
</div>
