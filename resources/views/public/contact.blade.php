<x-public-layout
    :seo-title="$seoTitle ?? null"
    :seo-description="$seoDescription ?? null"
    :seo-canonical="$seoCanonical ?? null"
    :seo-image="$seoImage ?? null"
    :seo-robots="$seoRobots ?? null"
>
    <div class="bg-white py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 tracking-tight mb-6">{{ __('Contact Us') }}</h1>
                    <p class="text-lg text-gray-500 mb-10">
                        {{ __('Have a question about the classes? Need help figuring out your current level? Send a message and we\'ll get back to you shortly.') }}
                    </p>

                    <div class="space-y-8">
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-accent-subtle rounded-xl flex items-center justify-center text-accent shrink-0">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">{{ __('Email') }}</h3>
                                <p class="text-gray-500 mt-1">germanacademy@gmail.com</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-accent-subtle rounded-xl flex items-center justify-center text-accent shrink-0">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">{{ __('Phone & WhatsApp') }}</h3>
                                <p class="text-gray-500 mt-1">+216 XX XXX XXX</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-[#FAFAFA] p-8 rounded-3xl border border-gray-100">
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800 flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="name" class="label">{{ __('Name') }}</label>
                            <input type="text" name="name" id="name" required class="input" value="{{ old('name') }}">
                            @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="email" class="label">{{ __('Email') }}</label>
                            <input type="email" name="email" id="email" required class="input" value="{{ old('email') }}">
                            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="subject" class="label">{{ __('Subject') }}</label>
                            <input type="text" name="subject" id="subject" class="input" value="{{ old('subject') }}">
                            @error('subject')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="message" class="label">{{ __('Message') }}</label>
                            <textarea name="message" id="message" rows="5" required class="input">{{ old('message') }}</textarea>
                            @error('message')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <button type="submit" class="btn-primary w-full py-3">{{ __('Send Message') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>