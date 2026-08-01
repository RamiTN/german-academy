<x-app-layout>
    <x-slot:header>
        {{ __('Good') }} {{ now()->hour < 12 ? __('morning') : (now()->hour < 17 ? __('afternoon') : __('evening')) }}, {{ explode(' ', auth()->user()->name)[0] }}! 👋
    </x-slot>

    <!-- Student Stats Mini Bar -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl p-4 border border-gray-100 flex items-center gap-4 shadow-sm">
            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">{{ __('Level') }}</p>
                <p class="font-bold text-gray-900">{{ $student->german_level->value ?? __('Pending') }}</p>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-4 border border-gray-100 flex items-center gap-4 shadow-sm">
            <div class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-medium">{{ __('Attendance') }}</p>
                <p class="font-bold text-gray-900">{{ $stats['attendance'] }}%</p>
            </div>
        </div>
    </div>

    <!-- The Feed -->
    <div class="max-w-3xl mx-auto space-y-6">
        @forelse($feed as $item)
            @if($item['type'] === 'live')
                <div class="bg-white rounded-2xl border-2 border-red-200 p-6 shadow-md shadow-red-100/50 relative overflow-hidden">
                    <div class="absolute top-0 end-0 w-32 h-32 bg-gradient-to-bl from-red-100 to-transparent rounded-bl-full opacity-50"></div>
                    <div class="flex items-start justify-between relative z-10">
                        <div>
                            <x-ui.live-indicator class="mb-3" />
                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $item['data']->title }}</h3>
                            <p class="text-gray-500">{{ __('Started') }} {{ $item['data']->started_at ? $item['data']->started_at->diffForHumans() : __('recently') }}</p>
                        </div>
                        <a href="{{ route('meetings.join', $item['data']) }}" target="_blank" class="btn bg-red-600 text-white hover:bg-red-700 px-6 py-3 shadow-sm font-bold inline-flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            {{ __('Join Live Meet') }} &rarr;
                        </a>
                    </div>
                </div>

            @elseif($item['type'] === 'next_lesson')
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm flex items-center gap-6">
                    <div class="w-16 h-16 rounded-xl bg-blue-50 text-blue-600 flex flex-col items-center justify-center border border-blue-100 shrink-0">
                        <span class="text-xs font-bold uppercase">{{ $item['data']->scheduled_at->format('M') }}</span>
                        <span class="text-2xl font-bold leading-none">{{ $item['data']->scheduled_at->format('d') }}</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider mb-1">{{ __('Upcoming Today') }}</p>
                        <h3 class="text-lg font-bold text-gray-900">{{ $item['data']->title }}</h3>
                        <p class="text-sm text-gray-500 flex items-center gap-2 mt-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ $item['data']->scheduled_at->format('H:i') }} ({{ $item['data']->scheduled_at->diffForHumans() }})
                        </p>
                    </div>
                    @if($item['data']->meet_link)
                        <a href="{{ route('meetings.join', $item['data']) }}" target="_blank" class="btn bg-blue-600 hover:bg-blue-700 text-white text-sm py-2 px-4 font-bold shrink-0">
                            {{ __('Join Meet') }} &rarr;
                        </a>
                    @endif
                </div>

            @elseif($item['type'] === 'homework')
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:border-accent hover:shadow-md transition-all group">
                    <div class="flex gap-4">
                        <div class="w-12 h-12 rounded-xl bg-accent-subtle text-accent flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="font-bold text-gray-900 group-hover:text-accent transition-colors">{{ $item['data']->title }}</h3>
                                    <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $item['data']->instructions }}</p>
                                </div>
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $item['data']->deadline->diffInHours() < 24 ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700' }} whitespace-nowrap">
                                    {{ __('Due') }} {{ $item['data']->deadline->diffForHumans() }}
                                </span>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-end gap-3">
                                <a href="#" class="btn-primary text-sm py-1.5 px-4">{{ __('Submit Assignment') }}</a>
                            </div>
                        </div>
                    </div>
                </div>

            @elseif($item['type'] === 'quiz')
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:border-purple-300 hover:shadow-md transition-all group">
                    <div class="flex items-center justify-between">
                        <div class="flex gap-4 items-center">
                            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $item['data']->title }}</h3>
                                <p class="text-sm text-gray-500">{{ $item['data']->time_limit_minutes ? $item['data']->time_limit_minutes . ' ' . __('mins') . ' • ' : '' }}{{ $item['data']->questions()->count() }} {{ __('questions') }}</p>
                            </div>
                        </div>
                        <a href="#" class="btn bg-purple-600 hover:bg-purple-700 text-white text-sm py-1.5 px-4">{{ __('Start Quiz') }}</a>
                    </div>
                </div>

            @elseif($item['type'] === 'announcement')
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm relative overflow-hidden">
                    @if($item['data']->is_pinned)
                        <div class="absolute top-0 end-0 w-16 h-16 overflow-hidden">
                            <div class="bg-accent text-white text-[10px] font-bold uppercase tracking-wider text-center py-1 absolute rotate-45 w-24 end-[-24px] top-[12px] shadow-sm">{{ __('Pinned') }}</div>
                        </div>
                    @endif
                    <div class="flex gap-4">
                        <img src="{{ $item['data']->creator->avatar_url }}" alt="{{ $item['data']->creator->name ?? 'User' }}" class="w-10 h-10 rounded-full mt-1">
                        <div>
                            <div class="flex items-baseline gap-2 mb-1">
                                <span class="font-bold text-gray-900">{{ $item['data']->creator->name }}</span>
                                <span class="text-xs text-gray-400">{{ $item['data']->published_at->diffForHumans() }}</span>
                            </div>
                            <h4 class="font-semibold text-lg text-gray-900 mb-2">{{ $item['data']->title }}</h4>
                            <div class="text-gray-600 text-sm prose prose-sm max-w-none">
                                {!! nl2br(e($item['data']->content)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="bg-white rounded-2xl border border-gray-200 p-12 text-center shadow-sm">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ __("You're all caught up!") }}</h3>
                <p class="text-gray-500 max-w-sm mx-auto">{{ __('No pending homework, quizzes, or upcoming lessons today. Enjoy your free time!') }}</p>
            </div>
        @endforelse
    </div>
</x-app-layout>
