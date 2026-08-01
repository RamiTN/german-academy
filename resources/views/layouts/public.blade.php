<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-site-verification" content="1xBqxMyauuiQXIKMweItmjjLY4nuy9phgyzH76dKSdw" />

    {{-- SEO: Title --}}
    <title>{{ $seoTitle ?? 'German Academy — Learn German Online A1 to C2' }}</title>

    {{-- SEO: Meta Description --}}
    @if($seoDescription ?? false)
    <meta name="description" content="{{ $seoDescription }}">
    @endif

    {{-- SEO: Canonical URL --}}
    <link rel="canonical" href="{{ $seoCanonical ?? url()->current() }}">

    {{-- SEO: Robots --}}
    <meta name="robots" content="{{ $seoRobots ?? 'index, follow' }}">

    {{-- SEO: Open Graph --}}
    <meta property="og:title" content="{{ $seoTitle ?? 'German Academy — Learn German Online A1 to C2' }}">
    @if($seoDescription ?? false)
    <meta property="og:description" content="{{ $seoDescription }}">
    @endif
    <meta property="og:image" content="{{ $seoImage ?? asset('images/og-default.jpg') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $seoCanonical ?? url()->current() }}">
    <meta property="og:site_name" content="German Academy">

    {{-- SEO: Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle ?? 'German Academy — Learn German Online A1 to C2' }}">
    @if($seoDescription ?? false)
    <meta name="twitter:description" content="{{ $seoDescription }}">
    @endif
    <meta name="twitter:image" content="{{ $seoImage ?? asset('images/og-default.jpg') }}">

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

    {{-- Per-page head content (JSON-LD, extra meta, etc.) --}}
    @stack('head')
</head>

<body class="font-sans text-gray-900 antialiased flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav x-data="{ mobileMenuOpen: false }" class="bg-white/95 backdrop-blur-md border-b border-gray-200/80 fixed w-full z-50 top-0 shadow-xs transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group transition-transform duration-200 hover:scale-[1.02]">
                        <img src="{{ asset('images/5cbf0526-b5b8-447b-b43f-0b04d9925d8b.png') }}" alt="German Academy logo" class="w-10 h-10 object-contain drop-shadow-xs">
                        <span class="font-bold text-xl tracking-tight text-gray-900 group-hover:text-red-600 transition-colors">{{ __('German Academy') }}</span>
                    </a>
                </div>

                <!-- Desktop Navigation Links (Big screens >= 1280px only to prevent crowding) -->
                <div class="hidden xl:flex xl:items-center xl:gap-8">
                    <a href="{{ route('home') }}" class="text-sm font-semibold text-gray-700 px-3.5 py-2 rounded-xl hover:bg-gray-100/80 hover:text-red-600 transition-all duration-200 {{ request()->routeIs('home') ? 'bg-red-50 text-red-600 font-bold' : '' }}">{{ __('Home') }}</a>
                    <a href="{{ route('about') }}" class="text-sm font-semibold text-gray-700 px-3.5 py-2 rounded-xl hover:bg-gray-100/80 hover:text-red-600 transition-all duration-200 {{ request()->routeIs('about') ? 'bg-red-50 text-red-600 font-bold' : '' }}">{{ __('About') }}</a>
                    <a href="{{ route('how-it-works') }}" class="text-sm font-semibold text-gray-700 px-3.5 py-2 rounded-xl hover:bg-gray-100/80 hover:text-red-600 transition-all duration-200 {{ request()->routeIs('how-it-works') ? 'bg-red-50 text-red-600 font-bold' : '' }}">{{ __('How It Works') }}</a>
                    <a href="{{ route('apply') }}" class="text-sm font-semibold text-gray-700 px-3.5 py-2 rounded-xl hover:bg-gray-100/80 hover:text-red-600 transition-all duration-200 {{ request()->routeIs('apply') ? 'bg-red-50 text-red-600 font-bold' : '' }}">{{ __('Apply') }}</a>
                    <a href="{{ route('contact') }}" class="text-sm font-semibold text-gray-700 px-3.5 py-2 rounded-xl hover:bg-gray-100/80 hover:text-red-600 transition-all duration-200 {{ request()->routeIs('contact') ? 'bg-red-50 text-red-600 font-bold' : '' }}">{{ __('Contact') }}</a>
                </div>

                <!-- Right Actions area -->
                <div class="flex items-center gap-4">
                    {{-- Language Switcher --}}
                    <div class="flex items-center gap-1 bg-gray-100/80 p-1 rounded-xl text-xs font-semibold">
                        <a href="{{ route('lang.switch', 'en') }}" class="px-2.5 py-1 rounded-lg transition-all duration-200 {{ app()->getLocale() == 'en' ? 'bg-accent text-white shadow-xs font-bold' : 'text-gray-600 hover:text-gray-900 hover:bg-white/50' }}">EN</a>
                        <a href="{{ route('lang.switch', 'ar') }}" class="px-2.5 py-1 rounded-lg transition-all duration-200 {{ app()->getLocale() == 'ar' ? 'bg-accent text-white shadow-xs font-bold' : 'text-gray-600 hover:text-gray-900 hover:bg-white/50' }}">AR</a>
                        <a href="{{ route('lang.switch', 'fr') }}" class="px-2.5 py-1 rounded-lg transition-all duration-200 {{ app()->getLocale() == 'fr' ? 'bg-accent text-white shadow-xs font-bold' : 'text-gray-600 hover:text-gray-900 hover:bg-white/50' }}">FR</a>
                    </div>

                    <!-- Desktop Auth Buttons (Big screens >= 1280px) -->
                    <div class="hidden xl:flex xl:items-center xl:gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-gray-700 hover:text-gray-900 px-4 py-2 rounded-xl hover:bg-gray-100/80 transition-all duration-200">{{ __('Dashboard') }}</a>
                            @if(auth()->user()->isStudent())
                                <a href="{{ route('apply') }}" class="btn-primary py-2 px-5 text-sm font-bold shadow-md hover:shadow-lg transition-all duration-200 rounded-xl">{{ __('Apply Now') }}</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-gray-900 px-4 py-2 rounded-xl hover:bg-gray-100/80 transition-all duration-200">{{ __('Log in') }}</a>
                            <a href="{{ route('apply') }}" class="btn-primary py-2 px-5 text-sm font-bold shadow-md hover:shadow-lg transition-all duration-200 rounded-xl">{{ __('Start Learning') }}</a>
                        @endauth
                    </div>

                    <!-- Hamburger Button (< 1280px: Tablets, Laptops & Mobile) -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="xl:hidden inline-flex items-center justify-center p-2.5 rounded-xl text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none transition-all duration-200">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path :class="{'hidden': mobileMenuOpen, 'inline-flex': !mobileMenuOpen }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !mobileMenuOpen, 'inline-flex': mobileMenuOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Drawer (< 1280px) -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-3"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-3"
             class="xl:hidden border-b border-gray-200 bg-white/98 backdrop-blur-xl px-6 pt-3 pb-6 space-y-2.5 shadow-2xl" 
             style="display: none;">
            
            <a href="{{ route('home') }}" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-gray-700 hover:bg-gray-100/80 hover:text-red-600 transition-colors {{ request()->routeIs('home') ? 'bg-red-50 text-red-600 font-bold' : '' }}">{{ __('Home') }}</a>
            <a href="{{ route('about') }}" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-gray-700 hover:bg-gray-100/80 hover:text-red-600 transition-colors {{ request()->routeIs('about') ? 'bg-red-50 text-red-600 font-bold' : '' }}">{{ __('About') }}</a>
            <a href="{{ route('how-it-works') }}" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-gray-700 hover:bg-gray-100/80 hover:text-red-600 transition-colors {{ request()->routeIs('how-it-works') ? 'bg-red-50 text-red-600 font-bold' : '' }}">{{ __('How It Works') }}</a>
            <a href="{{ route('apply') }}" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-gray-700 hover:bg-gray-100/80 hover:text-red-600 transition-colors {{ request()->routeIs('apply') ? 'bg-red-50 text-red-600 font-bold' : '' }}">{{ __('Apply') }}</a>
            <a href="{{ route('contact') }}" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-gray-700 hover:bg-gray-100/80 hover:text-red-600 transition-colors {{ request()->routeIs('contact') ? 'bg-red-50 text-red-600 font-bold' : '' }}">{{ __('Contact') }}</a>
            
            <div class="pt-4 border-t border-gray-100 space-y-2.5">
                @auth
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 rounded-xl text-base font-bold text-accent hover:bg-gray-100 transition-colors">{{ __('Dashboard') }} &rarr;</a>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-gray-700 hover:bg-gray-100 transition-colors">{{ __('Log in') }}</a>
                    <a href="{{ route('apply') }}" class="block btn-primary text-center py-3 text-base font-bold rounded-xl shadow-md">{{ __('Start Learning') }}</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow pt-20">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <img src="{{ asset('images/5cbf0526-b5b8-447b-b43f-0b04d9925d8b.png') }}" alt="German Academy logo" class="w-10 h-10 object-contain">
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