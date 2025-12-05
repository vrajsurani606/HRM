<x-guest-layout>
    <div class="min-h-screen bg-white dark:bg-slate-900">
        <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
            <div class="hidden lg:flex items-center justify-center p-8 bg-white dark:bg-slate-800">
                <div class="w-full h-full max-w-4xl max-h-[90vh] flex items-center justify-center">
                    <div class="w-full h-full max-h-[90vh] flex flex-col items-center justify-center text-center px-6">
                        <div class="mb-6 flex items-center justify-center">
                            <svg width="220" height="160" viewBox="0 0 220 160" xmlns="http://www.w3.org/2000/svg" aria-hidden>
                                <rect rx="12" width="220" height="160" fill="#eef2ff"></rect>
                                <g transform="translate(24,28)" fill="#6366f1" fill-opacity="0.9">
                                    <circle cx="34" cy="36" r="22"></circle>
                                    <rect x="78" y="18" width="88" height="36" rx="8"></rect>
                                </g>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Set a new password</h2>
                        <p class="text-slate-600 dark:text-slate-400 max-w-md">
                            Choose a strong new password to secure your HR Portal account.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center p-6 md:p-12 bg-slate-50 dark:bg-slate-900">
                <div class="w-full max-w-md">
                    <div class="text-center lg:text-left mb-6">
                        <h1 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Reset your password</h1>
                        <p class="text-slate-600 dark:text-slate-400">Enter your email and a new password to complete the reset.</p>
                    </div>

                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-6 md:p-8 border border-slate-200 dark:border-slate-700">
                        <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                            @csrf

                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <!-- Email Address -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                                <x-text-input
                                    id="email"
                                    class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-900 dark:text-white rounded-lg px-4 py-3 outline-none focus-visible:ring-[3px] focus-visible:ring-emerald-500/30 focus-visible:border-emerald-500 transition"
                                    type="email"
                                    name="email"
                                    :value="old('email', $request->email)"
                                    required
                                    autofocus
                                    autocomplete="username"
                                />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div>
                                <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                                <div class="password-wrapper">
                                    <x-text-input
                                        id="password"
                                        class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-900 dark:text-white rounded-lg px-4 py-3 outline-none focus-visible:ring-[3px] focus-visible:ring-emerald-500/30 focus-visible:border-emerald-500 transition"
                                        type="password"
                                        name="password"
                                        required
                                        autocomplete="new-password"
                                    />
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                                <div class="password-wrapper">
                                    <x-text-input
                                        id="password_confirmation"
                                        class="w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-slate-900 dark:text-white rounded-lg px-4 py-3 outline-none focus-visible:ring-[3px] focus-visible:ring-emerald-500/30 focus-visible:border-emerald-500 transition"
                                        type="password"
                                        name="password_confirmation"
                                        required
                                        autocomplete="new-password"
                                    />
                                </div>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <button type="submit" class="w-full h-11 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-medium shadow-md hover:shadow-lg transition">
                                {{ __('Reset Password') }}
                            </button>

                            <p class="text-center text-sm text-gray-600 dark:text-gray-400">
                                <a href="{{ route('login') }}" class="text-emerald-600 hover:underline font-medium">Back to login</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
