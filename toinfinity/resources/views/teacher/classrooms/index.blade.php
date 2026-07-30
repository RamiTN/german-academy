<x-app-layout>
    <x-slot:header>{{ __('Class Rooms & Live Lessons') }}</x-slot>

    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Class Rooms & Schedules') }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ __('Manage your active class groups, schedule lessons, and attach Google Meet links for student access.') }}</p>
        </div>
        <div>
            <a href="{{ route('meetings.create') }}" class="btn-primary inline-flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('Schedule New Lesson') }}
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
            <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
            <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <div class="space-y-8">
        @forelse($classGroups as $group)
            <x-ui.card>
                <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-gray-100 pb-4 mb-4 gap-4">
                    <div>
                        <div class="flex items-center gap-3">
                            <h3 class="text-xl font-bold text-gray-900">{{ $group->name }}</h3>
                            <x-ui.badge color="{{ $group->german_level->color() }}">{{ $group->german_level->value ?? $group->german_level }}</x-ui.badge>
                            @if(!$group->is_active)
                                <span class="text-xs font-semibold px-2 py-0.5 rounded bg-gray-100 text-gray-600">{{ __('Inactive') }}</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $group->description ?: __('No description provided.') }}
                        </p>
                    </div>
                    <div class="flex items-center gap-4 text-sm text-gray-600">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $group->students->count() }} / {{ $group->max_students }} {{ __('Students') }}</span>
                        </div>
                        @if(auth()->user()->isAdmin())
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>{{ $group->teacher->user->name ?? __('No Teacher Assigned') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Empty state: No teacher assigned --}}
                @if(!$group->teacher_id && auth()->user()->isAdmin())
                    <div class="mb-4 bg-amber-50 border border-amber-200 rounded-lg p-3 text-xs text-amber-800 flex items-center justify-between">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            {{ __('Warning: No teacher assigned to this class group yet.') }}
                        </span>
                        <a href="{{ route('admin.teachers.index') }}" class="font-bold underline text-amber-900 hover:text-amber-700">{{ __('Assign Teacher') }} &rarr;</a>
                    </div>
                @endif

                {{-- Meetings List --}}
                <div class="space-y-3">
                    <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Scheduled & Live Lessons') }}</h4>

                    @forelse($group->meetings as $meeting)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between bg-gray-50 hover:bg-gray-100/70 p-4 rounded-xl border border-gray-200 transition-colors gap-4">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-lg bg-white border border-gray-200 flex flex-col items-center justify-center text-xs font-bold shrink-0">
                                    <span class="text-blue-600 leading-none">{{ $meeting->scheduled_at ? $meeting->scheduled_at->format('M') : '' }}</span>
                                    <span class="text-gray-900 text-sm leading-none mt-0.5">{{ $meeting->scheduled_at ? $meeting->scheduled_at->format('d') : '' }}</span>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h5 class="font-bold text-gray-900 text-base">{{ $meeting->title }}</h5>
                                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $meeting->status->value === 'live' ? 'bg-red-100 text-red-700 animate-pulse' : ($meeting->status->value === 'scheduled' ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-700') }}">
                                            {{ $meeting->status->label() }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1 flex items-center gap-3">
                                        <span>🕒 {{ $meeting->scheduled_at ? $meeting->scheduled_at->format('H:i') . ' (' . $meeting->scheduled_at->diffForHumans() . ')' : 'N/A' }}</span>
                                        @if($meeting->meet_link)
                                            <span class="text-green-600 font-medium flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                {{ __('Meet Link Added') }}
                                            </span>
                                        @else
                                            <span class="text-amber-600 font-medium">⚠️ {{ __('No Meet Link Yet') }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 self-end sm:self-center">
                                @if($meeting->meet_link)
                                    <a href="{{ route('meetings.join', $meeting) }}" target="_blank" class="btn bg-green-600 hover:bg-green-700 text-white text-xs py-1.5 px-3 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        {{ __('Test Link') }}
                                    </a>
                                @endif

                                <a href="{{ route('meetings.edit', $meeting) }}" class="btn-primary text-xs py-1.5 px-3 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    {{ $meeting->meet_link ? __('Edit Link') : __('Add Meet Link') }}
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="bg-gray-50 rounded-xl p-6 text-center border border-dashed border-gray-200">
                            <p class="text-sm text-gray-500 mb-3">{{ __('No scheduled lessons or meetings for this class group yet.') }}</p>
                            <a href="{{ route('meetings.create') }}" class="btn-secondary text-xs inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                {{ __('Schedule First Lesson') }}
                            </a>
                        </div>
                    @endforelse
                </div>
            </x-ui.card>
        @empty
            <x-ui.card>
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">{{ __('No Class Groups Found') }}</h3>
                    <p class="text-sm text-gray-500 max-w-sm mx-auto mb-4">{{ __('There are no active class groups assigned to you yet.') }}</p>
                </div>
            </x-ui.card>
        @endforelse
    </div>
</x-app-layout>
