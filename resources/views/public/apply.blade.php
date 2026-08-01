<x-public-layout
    :seo-title="$seoTitle ?? null"
    :seo-description="$seoDescription ?? null"
    :seo-canonical="$seoCanonical ?? null"
    :seo-image="$seoImage ?? null"
    :seo-robots="$seoRobots ?? null"
>
    <div class="bg-[#FAFAFA] py-16 sm:py-24 min-h-[calc(100vh-64px)]">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 tracking-tight mb-4">{{ __('Apply for Classes') }}</h1>
                <p class="text-lg text-gray-500">{{ __('Fill out the form below to apply for upcoming groups. Spaces are limited.') }}</p>
            </div>

            @if(session('success'))
                <div class="mb-8 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800 flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            <x-ui.card class="p-8">
                <form action="{{ route('apply.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="label">{{ __('Full Name') }}</label>
                            <input type="text" name="name" id="name" required class="input" value="{{ old('name', auth()->user()->name) }}" placeholder="John Doe">
                            @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        
                        <div>
                            <label for="email" class="label">{{ __('Email Address') }}</label>
                            <input type="email" name="email" id="email" required class="input" value="{{ old('email', auth()->user()->email) }}" readonly placeholder="john@example.com">
                            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="phone" class="label">{{ __('Phone Number / WhatsApp') }}</label>
                            <input type="text" name="phone" id="phone" class="input" value="{{ old('phone', auth()->user()->phone) }}" placeholder="+1 234 567 890">
                            @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        
                        <div>
                            <label for="german_level" class="label">{{ __('Current German Level') }}</label>
                            <select name="german_level" id="german_level" required class="input">
                                <option value="" disabled selected>{{ __('Select your level') }}</option>
                                <option value="none" @selected(old('german_level') == 'none')>{{ __('Absolute Beginner (No prior knowledge)') }}</option>
                                <option value="A1" @selected(old('german_level') == 'A1')>A1 ({{ __('Beginner') }})</option>
                                <option value="A2" @selected(old('german_level') == 'A2')>A2 ({{ __('Elementary') }})</option>
                                <option value="B1" @selected(old('german_level') == 'B1')>B1 ({{ __('Intermediate') }})</option>
                                <option value="B2" @selected(old('german_level') == 'B2')>B2 ({{ __('Upper Intermediate') }})</option>
                                <option value="C1" @selected(old('german_level') == 'C1')>C1 ({{ __('Advanced') }})</option>
                                <option value="C2" @selected(old('german_level') == 'C2')>C2 ({{ __('Mastery') }})</option>
                            </select>
                            @error('german_level')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="preferred_schedule" class="label">{{ __('Preferred Schedule / Availability') }}</label>
                        <input type="text" name="preferred_schedule" id="preferred_schedule" class="input" value="{{ old('preferred_schedule') }}" placeholder="e.g. Weekday evenings, Weekends morning">
                        @error('preferred_schedule')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="message" class="label">{{ __('Additional Information') }}</label>
                        <textarea name="message" id="message" rows="4" class="input" placeholder="Tell us about your learning goals...">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="btn-primary w-full py-3 text-lg">{{ __('Submit Application') }}</button>
                    </div>
                </form>
            </x-ui.card>
        </div>
    </div>
</x-public-layout>
