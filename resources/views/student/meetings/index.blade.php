<x-app-layout>
    <x-slot:header>{{ __('My Meetings') }}</x-slot>

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">{{ __('My Meetings & Live Lessons') }}</h2>
        <p class="text-sm text-gray-500 mt-1">
            @if($classGroup)
                {{ __('Scheduled and live sessions for') }} <span class="font-semibold text-gray-700">{{ $classGroup->name }}</span>
            @else
                {{ __('You are not assigned to any class group yet.') }}
            @endif
        </p>
    </div>

    @if(!$classGroup)
        <x-ui.card>
            <div class="p-12 text-center">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-5">
                    <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('No Class Group Assigned') }}</h3>
                <p class="text-gray-500 max-w-sm mx-auto">{{ __('You haven\'t been assigned to a class group yet. Please contact your teacher or administrator.') }}</p>
            </div>
        </x-ui.card>
    @else
        <div class="space-y-8">

            {{-- Live Meetings --}}
            @if($liveMeetings->count() > 0)
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 animate-pulse"></span>
                        <h3 class="text-lg font-bold text-gray-900">{{ __('Live Now') }}</h3>
                    </div>
                    <div class="space-y-4">
                        @foreach($liveMeetings as $meeting)
                            <div class="bg-white rounded-2xl border-2 border-red-200 p-6 shadow-lg shadow-red-100/50 relative overflow-hidden">
                                <div class="absolute top-0 end-0 w-40 h-40 bg-gradient-to-bl from-red-100 to-transparent rounded-bl-full opacity-40"></div>
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 relative z-10">
                                    <div>
                                        <div class="flex items-center gap-2 mb-2">
                                            <x-ui.live-indicator />
                                        </div>
                                        <h4 class="text-xl font-bold text-gray-900 mb-1">{{ $meeting->title }}</h4>
                                        <p class="text-sm text-gray-500 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                            {{ $meeting->teacher?->user?->name ?? __('Teacher') }}
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            {{ __('Started') }} {{ $meeting->started_at ? $meeting->started_at->diffForHumans() : __('recently') }}
                                        </p>
                                    </div>
                                    @if($meeting->meet_link)
                                        <a href="{{ route('meetings.join', $meeting) }}" target="_blank" 
                                            class="btn bg-red-600 text-white hover:bg-red-700 px-8 py-3 shadow-md font-bold text-base inline-flex items-center gap-2 shrink-0 rounded-xl transition-all hover:shadow-lg hover:scale-[1.02]">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                            {{ __('Join Live Meet') }} &rarr;
                                        </a>
                                    @else
                                        <span class="text-sm text-amber-600 font-medium px-4 py-2 bg-amber-50 rounded-lg">
                                            ⚠️ {{ __('No Meet link added yet') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Upcoming Meetings --}}
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <h3 class="text-lg font-bold text-gray-900">{{ __('Upcoming Lessons') }}</h3>
                </div>

                @if($upcomingMeetings->count() > 0)
                    <div class="space-y-3">
                        @foreach($upcomingMeetings as $meeting)
                            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md hover:border-blue-200 transition-all duration-300">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div class="flex items-start gap-4">
                                        <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-600 flex flex-col items-center justify-center border border-blue-100 shrink-0">
                                            <span class="text-[10px] font-bold uppercase">{{ $meeting->scheduled_at->format('M') }}</span>
                                            <span class="text-xl font-bold leading-none">{{ $meeting->scheduled_at->format('d') }}</span>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900 text-base">{{ $meeting->title }}</h4>
                                            <p class="text-sm text-gray-500 flex items-center gap-3 mt-1">
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                    {{ $meeting->scheduled_at->format('H:i') }}
                                                </span>
                                                <span class="text-gray-400">{{ $meeting->scheduled_at->diffForHumans() }}</span>
                                            </p>
                                            @if($meeting->teacher?->user)
                                                <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                                    {{ $meeting->teacher->user->name }}
                                                </p>
                                            @endif
                                            @if($meeting->notes)
                                                <p class="text-xs text-gray-500 mt-2 line-clamp-1">📝 {{ $meeting->notes }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2 self-end sm:self-center">
                                        @if($meeting->meet_link)
                                            <a href="{{ route('meetings.join', $meeting) }}" target="_blank" 
                                                class="btn bg-green-600 hover:bg-green-700 text-white text-sm py-2 px-4 font-bold inline-flex items-center gap-1.5 rounded-lg shadow-sm transition-all hover:shadow">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                                {{ __('Join Meet') }}
                                            </a>
                                        @else
                                            <span class="text-xs text-amber-600 font-medium flex items-center gap-1 px-3 py-1.5 bg-amber-50 rounded-lg">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                {{ __('Link coming soon') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <x-ui.card>
                        <div class="p-8 text-center">
                            <div class="w-14 h-14 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1">{{ __('No Upcoming Lessons') }}</h4>
                            <p class="text-sm text-gray-500 max-w-sm mx-auto">{{ __('There are no scheduled lessons coming up. Check back later!') }}</p>
                        </div>
                    </x-ui.card>
                @endif
            </div>

            {{-- Past Meetings --}}
            @if($pastMeetings->count() > 0)
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <h3 class="text-lg font-bold text-gray-900">{{ __('Past Lessons') }}</h3>
                    </div>
                    <x-ui.card>
                        <div class="divide-y divide-gray-100">
                            @foreach($pastMeetings as $meeting)
                                <div class="flex items-center gap-4 py-3 px-1 {{ $meeting->status->value === 'cancelled' ? 'opacity-50' : '' }}">
                                    <div class="w-10 h-10 rounded-lg bg-gray-50 border border-gray-200 flex flex-col items-center justify-center text-[10px] font-bold shrink-0">
                                        <span class="text-gray-400 leading-none">{{ $meeting->scheduled_at ? $meeting->scheduled_at->format('M') : '' }}</span>
                                        <span class="text-gray-600 text-xs leading-none">{{ $meeting->scheduled_at ? $meeting->scheduled_at->format('d') : '' }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-700 {{ $meeting->status->value === 'cancelled' ? 'line-through' : '' }}">{{ $meeting->title }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-2">
                                            <span>{{ $meeting->scheduled_at ? $meeting->scheduled_at->format('H:i') : '' }}</span>
                                            <span class="text-[10px] px-1.5 py-0.5 rounded-full {{ $meeting->status->value === 'ended' ? 'bg-gray-100 text-gray-600' : 'bg-red-50 text-red-500' }}">
                                                {{ $meeting->status->label() }}
                                            </span>
                                            @if($meeting->duration)
                                                <span>{{ $meeting->duration }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-ui.card>
                </div>
            @endif

        </div>
    @endif
</x-app-layout>
