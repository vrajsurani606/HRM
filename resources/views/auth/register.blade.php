<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
        <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
            <div class="hidden lg:flex items-center justify-center p-8 bg-gradient-to-br from-blue-600 to-purple-700">
                <div class="w-full h-full max-w-4xl max-h-[90vh] flex items-center justify-center">
                    <lottie-player
                    src="{{ asset('lottie/register-animation.json') }}"
                    background="transparent"
                    speed="1"
                    loop
                    autoplay
                    style="width:100%;height:100%;max-height:90vh;"
                    ></lottie-player>
                </div>
            </div>  

            <div class="flex items-center justify-center p-6 md:p-12">
                <div class="w-full max-w-md">
                    <div class="text-center lg:text-left mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Create Account</h1>
                        <p class="text-gray-600">Join HR Portal and manage your workforce efficiently</p>
                    </div>

                    <div class="bg-white rounded-2xl shadow-2xl p-8 border border-gray-100">
                        <form method="POST" action="{{ route('register') }}" class="space-y-5">
                            @csrf

                            <div>
                                <x-input-label for="name" :value="__('Full Name')" class="block text-sm font-semibold text-gray-700 mb-2" />
                                <x-text-input
                                    id="name"
                                    class="w-full border-2 border-gray-200 bg-gray-50 text-gray-900 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    type="text"
                                    name="name"
                                    :value="old('name')"
                                    required
                                    autofocus
                                    autocomplete="name"
                                    placeholder="Enter your full name"
                                />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email Address')" class="block text-sm font-semibold text-gray-700 mb-2" />
                                <x-text-input
                                    id="email"
                                    class="w-full border-2 border-gray-200 bg-gray-50 text-gray-900 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    type="email"
                                    name="email"
                                    :value="old('email')"
                                    required
                                    autocomplete="username"
                                    placeholder="Enter your email address"
                                />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="password" :value="__('Password')" class="block text-sm font-semibold text-gray-700 mb-2" />
                                <x-text-input
                                    id="password"
                                    class="w-full border-2 border-gray-200 bg-gray-50 text-gray-900 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Create a strong password"
                                />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="block text-sm font-semibold text-gray-700 mb-2" />
                                <x-text-input
                                    id="password_confirmation"
                                    class="w-full border-2 border-gray-200 bg-gray-50 text-gray-900 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    type="password"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Confirm your password"
                                />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <button type="submit" class="w-full h-12 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200">
                                Create Account
                            </button>

                            <p class="text-center text-sm text-gray-600 mt-6">
                                Already have an account?
                                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold hover:underline transition-colors">Sign in here</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</x-guest-layout>

