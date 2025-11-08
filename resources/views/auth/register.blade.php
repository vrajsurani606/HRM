<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-rose-50 via-white to-amber-50 flex items-center justify-center py-8 px-4">
        <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="hidden lg:flex rounded-2xl bg-white/70 ring-1 ring-gray-200 p-8 relative overflow-hidden">
                <div class="m-auto max-w-sm text-center">
                    <div class="mx-auto mb-6 h-14 w-14 rounded-2xl bg-emerald-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-7 w-7 text-emerald-600"><path fill="currentColor" d="M12 2a10 10 0 1 0 10 10A10.01 10.01 0 0 0 12 2m-1 15l-5-5l1.41-1.41L11 13.17l5.59-5.59L18 9z"/></svg>
                    </div>
                    <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">Create your account</h2>
                    <p class="mt-2 text-gray-600">Sign up to access projects, HR tools and more.</p>
                    <ul class="mt-6 text-left space-y-3 text-gray-700">
                        <li class="flex items-start gap-3"><span class="mt-1 h-2 w-2 rounded-full bg-emerald-500"></span> Fast onboarding</li>
                        <li class="flex items-start gap-3"><span class="mt-1 h-2 w-2 rounded-full bg-rose-500"></span> Secure password rules</li>
                        <li class="flex items-start gap-3"><span class="mt-1 h-2 w-2 rounded-full bg-amber-500"></span> Email verification ready</li>
                    </ul>
                </div>
            </div>

            <div class="bg-white/90 backdrop-blur rounded-2xl ring-1 ring-gray-200 p-6 sm:p-8">
                <div class="mb-6">
                    <h1 class="text-2xl font-black text-gray-900">Register</h1>
                    <p class="text-sm text-gray-600">Fill your details to create an account.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="pt-2">
                        <x-primary-button class="w-full justify-center bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>

                    <div class="text-center text-sm text-gray-600">
                        {{ __('Already registered?') }}
                        <a href="{{ route('login') }}" class="font-semibold text-emerald-600 hover:text-emerald-700">{{ __('Sign in') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
