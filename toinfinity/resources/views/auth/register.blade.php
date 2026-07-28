<x-public-layout>
    <div class="bg-[#FAFAFA] py-16 sm:py-24 min-h-[calc(100vh-64px)] flex items-center justify-center">
        <div class="max-w-md w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900 tracking-tight mb-2">{{ __('Create an Account') }}</h1>
                <p class="text-lg text-gray-500">{{ __('Join the German Academy today.') }}</p>
            </div>

            <x-ui.card class="p-8">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="label">{{ __('Full Name') }}</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="input" placeholder="John Doe">
                        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="label">{{ __('Email Address') }}</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="input" placeholder="john@example.com">
                        @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role" class="label">{{ __('Account Type') }}</label>
                        <select id="role" name="role" required class="input">
                            <option value="" disabled selected>{{ __('Select an account type') }}</option>
                            <option value="student" @selected(old('role') == 'student')>{{ __('Student') }}</option>
                            <option value="teacher" @selected(old('role') == 'teacher')>{{ __('Teacher') }}</option>
                        </select>
                        @error('role')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="label">{{ __('Password') }}</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password" class="input mt-2">
                        @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="label">{{ __('Confirm Password') }}</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="input mt-2">
                        @error('password_confirmation')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <button type="submit" class="btn-primary w-full py-3 text-lg">{{ __('Register') }}</button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        {{ __('Already have an account?') }} 
                        <a href="{{ route('login') }}" class="font-medium text-accent hover:text-accent-hover">{{ __('Log in') }}</a>
                    </p>
                </div>
            </x-ui.card>
        </div>
    </div>
</x-public-layout>
