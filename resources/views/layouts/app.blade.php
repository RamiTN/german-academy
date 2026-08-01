<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('German Academy') }} - {{ __('Dashboard') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/5cbf0526-b5b8-447b-b43f-0b04d9925d8b.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400&display=swap" rel="stylesheet">
    @if(app()->getLocale() == 'ar')
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .btn-primary:hover { background-color: #dc2626 !important; color: #D4A843 !important; }
        [dir="rtl"] body { font-family: 'Noto Sans Arabic', 'Inter', sans-serif; }
    </style>
</head>
<body class="font-sans text-[#171717] bg-[#FAFAFA] antialiased" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" 
         class="fixed inset-0 z-40 bg-gray-900/50 lg:hidden backdrop-blur-sm transition-opacity"
         @click="sidebarOpen = false" style="display: none;"></div>

    <!-- Sidebar -->
    <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
         class="fixed inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 border-l' : 'left-0 border-r' }} z-50 w-64 bg-white border-gray-200 transition-transform duration-300 ease-in-out lg:translate-x-0 flex flex-col">
        
        <!-- Logo -->
        <div class="h-16 flex items-center px-6 border-b border-gray-200">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/5cbf0526-b5b8-447b-b43f-0b04d9925d8b.png') }}" alt="German Academy logo" class="w-8 h-8 object-contain">
                <span class="font-bold text-lg text-gray-900">{{ __('German Academy') }}</span>
            </a>
        </div>

        <!-- Navigation Links -->
        <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            @if(auth()->user()->isAdmin())
                <x-ui.nav-item route="admin.dashboard" icon="squares-2x2" :label="__('Dashboard')" />
                
                <div class="mt-4 mb-2 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Management') }}</div>
                <x-ui.nav-item route="admin.students.index" icon="users" :label="__('All Students')" />
                <x-ui.nav-item route="admin.teachers.index" icon="academic-cap" :label="__('All Teachers')" />
                <x-ui.nav-item route="admin.applications.index" icon="document-text" :label="__('Student Applications')" />
                
                <div class="mt-4 mb-2 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Academic') }}</div>
                <x-ui.nav-item route="admin.schedules.index" icon="calendar" :label="__('Class Schedules')" />
                <x-ui.nav-item route="admin.announcements.index" icon="megaphone" :label="__('Announcements')" />
                <x-ui.nav-item route="admin.homework.index" icon="book-open" :label="__('Homework Assignments')" />
                <x-ui.nav-item route="admin.quizzes.index" icon="question-mark-circle" :label="__('Quizzes')" />
                <x-ui.nav-item route="admin.tests.index" icon="clipboard-document-check" :label="__('Module Tests')" />
                <x-ui.nav-item route="admin.resources.index" icon="folder" :label="__('Learning Resources')" />

                <div class="mt-4 mb-2 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('System') }}</div>
                <x-ui.nav-item route="admin.settings.index" icon="cog-6-tooth" :label="__('Settings')" />
                <x-ui.nav-item route="admin.logs.index" icon="server" :label="__('Activity Logs')" />
            @elseif(auth()->user()->isTeacher())
                <x-ui.nav-item route="teacher.dashboard" icon="squares-2x2" :label="__('Dashboard')" />
                <x-ui.nav-item route="teacher.class-groups.index" icon="user-group" :label="__('Class Groups')" />
                <x-ui.nav-item route="teacher.classrooms.index" icon="video-camera" :label="__('Class Rooms')" />
                <x-ui.nav-item route="teacher.students.index" icon="users" :label="__('My Students')" />
                <x-ui.nav-item route="teacher.applications.index" icon="document-text" :label="__('Applications')" />
                <x-ui.nav-item route="teacher.homework.index" icon="book-open" :label="__('Homework')" />
                <x-ui.nav-item route="teacher.quizzes.index" icon="question-mark-circle" :label="__('Quizzes')" />
                <x-ui.nav-item route="teacher.tests.index" icon="clipboard-document-check" :label="__('Tests')" />
                <x-ui.nav-item route="teacher.announcements.index" icon="megaphone" :label="__('Announcements')" />
                <x-ui.nav-item route="teacher.resources.index" icon="folder" :label="__('Resources')" />
            @else
                <x-ui.nav-item route="student.dashboard" icon="home" :label="__('My Feed')" />
                <x-ui.nav-item route="student.meetings.index" icon="video-camera" :label="__('My Meetings')" />
                <x-ui.nav-item route="student.homework.index" icon="book-open" :label="__('Homework')" />
                <x-ui.nav-item route="student.quizzes.index" icon="question-mark-circle" :label="__('Quizzes')" />
                <x-ui.nav-item route="student.tests.index" icon="clipboard-document-check" :label="__('Tests')" />
                <x-ui.nav-item route="student.resources.index" icon="folder" :label="__('Resources')" />
                <x-ui.nav-item route="student.grades.index" icon="chart-bar" :label="__('Grades')" />
                <x-ui.nav-item route="student.attendance.index" icon="check-circle" :label="__('Attendance')" />
            @endif
        </div>
        
        <!-- User Profile Area -->
        <div class="border-t border-gray-200 p-4">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 hover:bg-gray-50 rounded-lg p-2 transition-colors">
                <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full object-cover">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ __(ucfirst(auth()->user()->role->value)) }}</p>
                </div>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="w-full text-start px-2 py-1.5 text-sm text-red-600 font-medium hover:bg-red-50 rounded-md transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    {{ __('Log out') }}
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="{{ app()->getLocale() == 'ar' ? 'lg:pr-64' : 'lg:pl-64' }} flex flex-col min-h-screen">
        
        <!-- Topbar -->
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 sm:px-6 z-30">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="text-lg font-semibold text-gray-900">{{ $header ?? '' }}</h1>
            </div>

            <div class="flex items-center gap-4">
                <!-- Language Switcher -->
                <div class="flex items-center gap-1 text-xs">
                    <a href="{{ route('lang.switch', 'en') }}" class="px-1.5 py-0.5 rounded {{ app()->getLocale() == 'en' ? 'bg-accent text-white' : 'text-gray-500 hover:text-gray-900' }}">EN</a>
                    <a href="{{ route('lang.switch', 'ar') }}" class="px-1.5 py-0.5 rounded {{ app()->getLocale() == 'ar' ? 'bg-accent text-white' : 'text-gray-500 hover:text-gray-900' }}">AR</a>
                    <a href="{{ route('lang.switch', 'fr') }}" class="px-1.5 py-0.5 rounded {{ app()->getLocale() == 'fr' ? 'bg-accent text-white' : 'text-gray-500 hover:text-gray-900' }}">FR</a>
                </div>

                <!-- Notifications -->
                <x-ui.notification-bell />
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            {{ $slot }}
        </main>
    </div>

</body>
</html>
