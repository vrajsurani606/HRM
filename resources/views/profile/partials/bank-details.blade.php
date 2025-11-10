<div class="hrp-form">
  <div style="margin-bottom: 28px;">
    <h2 style="font-size: 22px; font-weight: 800; color: #111; margin: 0 0 10px 0; line-height: 1.3; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
      {{ __('Bank Details') }}
    </h2>
    <p style="font-size: 14px; color: #6b7280; margin: 0; line-height: 1.6; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
      {{ __('View and manage your bank account information for salary payments.') }}
    </p>
  </div>

  @if($employee)
  <form method="post" action="{{ route('profile.bank.update') }}">
    @csrf
    @method('patch')

    <div class="hrp-grid">
      <div class="hrp-col-6">
        <label class="hrp-label Mobile-No" for="bank_name">Bank Name <span style="color: #ef4444;">*</span></label>
        <input type="text" id="bank_name" name="bank_name" class="Rectangle-29" 
               value="{{ old('bank_name', $employee->bank_name ?? '') }}" required 
               placeholder="{{ __('Enter bank name') }}" />
        @if($errors->get('bank_name'))
          <div style="color: #ef4444; font-size: 13px; margin-top: 8px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            {{ $errors->first('bank_name') }}
          </div>
        @endif
      </div>

      <div class="hrp-col-6">
        <label class="hrp-label Mobile-No" for="bank_account_no">Account Number <span style="color: #ef4444;">*</span></label>
        <input type="text" id="bank_account_no" name="bank_account_no" class="Rectangle-29" 
               value="{{ old('bank_account_no', $employee->bank_account_no ?? '') }}" required 
               placeholder="{{ __('Enter account number') }}" maxlength="30" />
        @if($errors->get('bank_account_no'))
          <div style="color: #ef4444; font-size: 13px; margin-top: 8px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            {{ $errors->first('bank_account_no') }}
          </div>
        @endif
      </div>
    </div>

    <div class="hrp-grid" style="margin-top: 20px;">
      <div class="hrp-col-6">
        <label class="hrp-label Mobile-No" for="bank_ifsc">IFSC Code <span style="color: #ef4444;">*</span></label>
        <input type="text" id="bank_ifsc" name="bank_ifsc" class="Rectangle-29" 
               value="{{ old('bank_ifsc', $employee->bank_ifsc ?? '') }}" required 
               placeholder="{{ __('Enter IFSC code') }}" maxlength="11" 
               style="text-transform: uppercase;" pattern="[A-Z]{4}0[A-Z0-9]{6}" />
        @if($errors->get('bank_ifsc'))
          <div style="color: #ef4444; font-size: 13px; margin-top: 8px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            {{ $errors->first('bank_ifsc') }}
          </div>
        @endif
      </div>

      <div class="hrp-col-6">
        <label class="hrp-label Mobile-No">Account Holder Name</label>
        <input type="text" class="Rectangle-29" 
               value="{{ $employee->name ?? $user->name }}" readonly 
               style="background: #f9fafb; cursor: not-allowed;" />
        <small style="color: #6b7280; font-size: 12px; margin-top: 6px; display: block; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
          Account holder name matches your profile name
        </small>
      </div>
    </div>

    <div class="hrp-grid" style="margin-top: 20px;">
      <div class="hrp-col-12">
        <label class="hrp-label Mobile-No">Bank Cheque/Cancelled Cheque</label>
        @if($employee->cheque_photo)
          <div style="margin-top: 8px;">
            <a href="{{ asset('storage/' . $employee->cheque_photo) }}" target="_blank" 
               class="hrp-btn" style="background: #f3f4f6; color: #111; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-weight: 800;">
              <i class="fa fa-eye"></i> View Cheque
            </a>
          </div>
        @else
          <p style="color: #ef4444; font-size: 13px; margin-top: 8px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            <i class="fa fa-exclamation-triangle"></i> Cheque not uploaded
          </p>
        @endif
      </div>
    </div>

    <!-- Bank Details Summary Card -->
    <div class="hrp-card" style="margin-top: 32px; background: #f9fafb; border: 1px solid #e5e7eb;">
      <div class="hrp-card-body">
        <h3 style="font-size: 16px; font-weight: 700; color: #111; margin: 0 0 16px 0; padding-bottom: 12px; border-bottom: 2px solid #e5e7eb; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
          <i class="fa fa-info-circle"></i> Current Bank Details
        </h3>
        <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f3f4f6;">
          <span style="font-weight: 600; color: #6b7280; font-size: 14px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">Bank Name</span>
          <span style="font-weight: 500; color: #111; font-size: 14px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">{{ $employee->bank_name ?? 'Not Provided' }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f3f4f6;">
          <span style="font-weight: 600; color: #6b7280; font-size: 14px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">Account Number</span>
          <span style="font-weight: 500; color: #111; font-size: 14px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            @if($employee->bank_account_no)
              {{ substr($employee->bank_account_no, 0, 4) }}****{{ substr($employee->bank_account_no, -4) }}
            @else
              Not Provided
            @endif
          </span>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f3f4f6;">
          <span style="font-weight: 600; color: #6b7280; font-size: 14px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">IFSC Code</span>
          <span style="font-weight: 500; color: #111; font-size: 14px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">{{ $employee->bank_ifsc ?? 'Not Provided' }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 12px 0;">
          <span style="font-weight: 600; color: #6b7280; font-size: 14px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">Account Status</span>
          <span style="font-weight: 500; font-size: 14px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            @if($employee->bank_name && $employee->bank_account_no && $employee->bank_ifsc)
              <span style="color: #10b981; font-weight: 600;">
                <i class="fa fa-check-circle"></i> Active
              </span>
            @else
              <span style="color: #ef4444; font-weight: 600;">
                <i class="fa fa-times-circle"></i> Incomplete
              </span>
            @endif
          </span>
        </div>
      </div>
    </div>

    <div class="hrp-actions" style="margin-top: 32px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
      <button type="submit" class="hrp-btn hrp-btn-primary" style="font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-weight: 800;">
        <i class="fa fa-save"></i> {{ __('Update Bank Details') }}
      </button>

      @if (session('status') === 'bank-updated')
        <p style="color: #10b981; margin: 0 0 0 16px; font-size: 14px; font-weight: 600; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
          <i class="fa fa-check-circle"></i> {{ __('Bank details updated successfully.') }}
        </p>
      @endif
    </div>
  </form>
  @else
  <div class="hrp-card" style="text-align: center; padding: 40px; background: #f9fafb; border: 1px solid #e5e7eb;">
    <i class="fa fa-info-circle" style="font-size: 48px; color: #9ca3af; margin-bottom: 16px;"></i>
    <p style="color: #6b7280; font-size: 16px; margin: 0; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
      No bank details available. Please contact HR to add your bank information.
    </p>
  </div>
  @endif
</div>
