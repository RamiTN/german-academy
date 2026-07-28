<x-public-layout>
    <div class="bg-[#FAFAFA] py-16 sm:py-24 min-h-[calc(100vh-64px)] flex items-center justify-center">
        <div class="max-w-md w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900 tracking-tight mb-2">{{ __('Welcome back') }}</h1>
                <p class="text-lg text-gray-500">{{ __('Log in to your account to continue.') }}</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <x-ui.card class="p-8">
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="label">{{ __('Email Address') }}</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="input" placeholder="john@example.com">
                        @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="label mb-0">{{ __('Password') }}</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm font-medium text-accent hover:text-accent-hover">{{ __('Forgot password?') }}</a>
                            @endif
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="input mt-2">
                        @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-accent border-gray-300 rounded focus:ring-accent">
                        <label for="remember_me" class="ms-2 block text-sm text-gray-900">{{ __('Remember me') }}</label>
                    </div>

                    <div>
                        <button type="submit" class="btn-primary w-full py-3 text-lg">{{ __('Log in') }}</button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        {{ __("Don't have an account?") }} 
                        <a href="{{ route('register') }}" class="font-medium text-accent hover:text-accent-hover">{{ __('Sign up') }}</a>
                    </p>
                </div>
            </x-ui.card>
        </div>
    </div>
</x-public-layout>
