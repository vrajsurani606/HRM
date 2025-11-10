<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6">
        @csrf
        @method('patch')

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input type="text" id="name" name="name" class="form-control" 
                           value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                    @if($errors->get('name'))
                        <div class="text-danger mt-1" style="font-size: 13px;">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">{{ __('Email') }}</label>
                    <input type="email" id="email" name="email" class="form-control" 
                           value="{{ old('email', $user->email) }}" required autocomplete="username" />
                    @if($errors->get('email'))
                        <div class="text-danger mt-1" style="font-size: 13px;">
                            {{ $errors->first('email') }}
                        </div>
                    @endif

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-2">
                            <p class="text-sm" style="color: #6b7280;">
                                {{ __('Your email address is unverified.') }}

                                <button form="send-verification" type="button" class="btn-link" style="color: #0ea5e9; text-decoration: underline; border: none; background: none; padding: 0;">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm" style="color: #10b981;">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4" style="display: flex; align-items: center; gap: 16px; margin-top: 24px;">
            <button type="submit" class="hrp-btn hrp-btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm" style="color: #10b981; margin: 0;">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
