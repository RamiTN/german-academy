<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('German Academy') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/5cbf0526-b5b8-447b-b43f-0b04d9925d8b.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400&display=swap" rel="stylesheet">
    @if(app()->getLocale() == 'ar')
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
    @endif

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Inline hover fix + RTL helpers --}}
    <style>
        .btn-primary:hover { background-color: #dc2626 !important; color: #D4A843 !important; }
        [dir="rtl"] body { font-family: 'Noto Sans Arabic', 'Inter', sans-serif; }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-200 fixed w-full z-50 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/5cbf0526-b5b8-447b-b43f-0b04d9925d8b.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                        <span class="font-bold text-xl text-gray-900">{{ __('German Academy') }}</span>
                    </a>
                </div>

                <div class="hidden sm:flex sm:items-center sm:gap-8">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">{{ __('Home') }}</a>
                    <a href="{{ route('about') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">{{ __('About') }}</a>
                    <a href="{{ route('how-it-works') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">{{ __('How It Works') }}</a>
                    <a href="{{ route('apply') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">{{ __('Apply') }}</a>
                    <a href="{{ route('contact') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">{{ __('Contact') }}</a>
                </div>

                <div class="flex items-center gap-4">
                    {{-- Language Switcher --}}
                    <div class="flex items-center gap-1 text-xs">
                        <a href="{{ route('lang.switch', 'en') }}" class="px-1.5 py-0.5 rounded {{ app()->getLocale() == 'en' ? 'bg-accent text-white' : 'text-gray-500 hover:text-gray-900' }}">EN</a>
                        <a href="{{ route('lang.switch', 'ar') }}" class="px-1.5 py-0.5 rounded {{ app()->getLocale() == 'ar' ? 'bg-accent text-white' : 'text-gray-500 hover:text-gray-900' }}">AR</a>
                        <a href="{{ route('lang.switch', 'fr') }}" class="px-1.5 py-0.5 rounded {{ app()->getLocale() == 'fr' ? 'bg-accent text-white' : 'text-gray-500 hover:text-gray-900' }}">FR</a>
                    </div>

                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">{{ __('Dashboard') }}</a>
                        @if(auth()->user()->isStudent())
                            <a href="{{ route('apply') }}" class="btn-primary py-1.5 text-sm">{{ __('Apply Now') }}</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">{{ __('Log in') }}</a>
                        <a href="{{ route('apply') }}" class="btn-primary py-1.5 text-sm">{{ __('Start Learning') }}</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow pt-16">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <img src="{{ asset('images/5cbf0526-b5b8-447b-b43f-0b04d9925d8b.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                    <span class="font-bold text-xl">{{ __('German Academy') }}</span>
                </div>
                <p class="text-gray-400 text-sm max-w-md">
                    {{ __('Master the German language with live interactive lessons, structured curriculum, and a premium learning experience tailored for real results.') }}
                </p>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4">{{ __('Quick Links') }}</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">{{ __('Home') }}</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">{{ __('About the Teacher') }}</a></li>
                    <li><a href="{{ route('apply') }}" class="hover:text-white transition-colors">{{ __('Apply Now') }}</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-white mb-4">{{ __('Contact') }}</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li>germanacademy@gmail.com</li>
                    <li>+216 XX XXX XXX</li>
                    <li class="pt-2"><a href="{{ route('contact') }}" class="text-accent hover:text-accent-hover transition-colors">{{ __('Send a Message') }} &rarr;</a></li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-8 border-t border-gray-800 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} {{ __('German Academy') }}. {{ __('All rights reserved.') }}
        </div>
    </footer>
</body>

</html>