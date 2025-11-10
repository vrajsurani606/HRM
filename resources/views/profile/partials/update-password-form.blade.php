<div class="hrp-form">
  <div style="margin-bottom: 28px;">
    <h2 style="font-size: 22px; font-weight: 800; color: #111; margin: 0 0 10px 0; line-height: 1.3; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
      {{ __('Update Password') }}
    </h2>
    <p style="font-size: 14px; color: #6b7280; margin: 0; line-height: 1.6; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
      {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </p>
  </div>

  <form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="hrp-grid">
      <div class="hrp-col-4">
        <label class="hrp-label Mobile-No" for="update_password_current_password">{{ __('Current Password') }} <span style="color: #ef4444;">*</span></label>
        <input type="password" id="update_password_current_password" name="current_password" 
               class="Rectangle-29" autocomplete="current-password" 
               placeholder="{{ __('Enter current password') }}" required />
        @if($errors->updatePassword->get('current_password'))
          <div style="color: #ef4444; font-size: 13px; margin-top: 8px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            {{ $errors->updatePassword->first('current_password') }}
          </div>
        @endif
      </div>

      <div class="hrp-col-4">
        <label class="hrp-label Mobile-No" for="update_password_password">{{ __('New Password') }} <span style="color: #ef4444;">*</span></label>
        <input type="password" id="update_password_password" name="password" 
               class="Rectangle-29" autocomplete="new-password" 
               placeholder="{{ __('Enter new password') }}" required />
        @if($errors->updatePassword->get('password'))
          <div style="color: #ef4444; font-size: 13px; margin-top: 8px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            {{ $errors->updatePassword->first('password') }}
          </div>
        @endif
      </div>

      <div class="hrp-col-4">
        <label class="hrp-label Mobile-No" for="update_password_password_confirmation">{{ __('Confirm Password') }} <span style="color: #ef4444;">*</span></label>
        <input type="password" id="update_password_password_confirmation" name="password_confirmation" 
               class="Rectangle-29" autocomplete="new-password" 
               placeholder="{{ __('Confirm new password') }}" required />
        @if($errors->updatePassword->get('password_confirmation'))
          <div style="color: #ef4444; font-size: 13px; margin-top: 8px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
            {{ $errors->updatePassword->first('password_confirmation') }}
          </div>
        @endif
      </div>
    </div>

    <div class="hrp-actions" style="margin-top: 32px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
      <button type="submit" class="hrp-btn hrp-btn-primary" style="font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-weight: 800;">
        <i class="fa fa-save"></i> {{ __('Save') }}
      </button>

      @if (session('status') === 'password-updated')
        <p style="color: #10b981; margin: 0 0 0 16px; font-size: 14px; font-weight: 600; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
          <i class="fa fa-check-circle"></i> {{ __('Saved.') }}
        </p>
      @endif
    </div>
  </form>
</div>
