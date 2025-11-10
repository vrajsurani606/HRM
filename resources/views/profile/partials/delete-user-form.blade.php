<div class="hrp-form">
  <div style="margin-bottom: 28px;">
    <h2 style="font-size: 22px; font-weight: 800; color: #111; margin: 0 0 10px 0; line-height: 1.3; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
      {{ __('Delete Account') }}
    </h2>
    <p style="font-size: 14px; color: #6b7280; margin: 0; line-height: 1.6;">
      {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
    </p>
  </div>

  <button type="button" class="hrp-btn" style="background: #ef4444; color: white; margin-top: 20px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;" 
          data-toggle="modal" data-target="#deleteAccountModal">
    <i class="fa fa-trash"></i> {{ __('Delete Account') }}
  </button>

  <!-- Delete Account Modal -->
  <div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 16px; border: 1px solid #e5e7eb;">
        <form method="post" action="{{ route('profile.destroy') }}">
          @csrf
          @method('delete')

          <div class="modal-header" style="border-bottom: 1px solid #e5e7eb; padding: 24px 30px;">
            <h4 class="modal-title" id="deleteAccountModalLabel" style="font-size: 20px; font-weight: 800; color: #111; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
              {{ __('Are you sure you want to delete your account?') }}
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity: 0.5;">
              <span aria-hidden="true" style="font-size: 28px; color: #6b7280;">&times;</span>
            </button>
          </div>

          <div class="modal-body" style="padding: 24px 30px;">
            <p style="color: #6b7280; margin-bottom: 24px; font-size: 14px; line-height: 1.6; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
              {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div style="margin-bottom: 0;">
              <label class="hrp-label Mobile-No" for="password">{{ __('Password') }} <span style="color: #ef4444;">*</span></label>
              <input type="password" id="password" name="password" class="Rectangle-29" 
                     placeholder="{{ __('Enter your password') }}" required />
              @if($errors->userDeletion->get('password'))
                <div style="color: #ef4444; font-size: 13px; margin-top: 8px; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
                  {{ $errors->userDeletion->first('password') }}
                </div>
              @endif
            </div>
          </div>

          <div class="modal-footer" style="border-top: 1px solid #e5e7eb; padding: 20px 30px; display: flex; justify-content: flex-end; gap: 12px;">
            <button type="button" class="hrp-btn" data-dismiss="modal" style="background: #f3f4f6; color: #111; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
              {{ __('Cancel') }}
            </button>
            <button type="submit" class="hrp-btn" style="background: #ef4444; color: white; font-family: 'Visby', 'Visby CF', 'VisbyCF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
              <i class="fa fa-trash"></i> {{ __('Delete Account') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @if($errors->userDeletion->isNotEmpty())
    <script>
      $(document).ready(function() {
        $('#deleteAccountModal').modal('show');
      });
    </script>
  @endif
</div>
