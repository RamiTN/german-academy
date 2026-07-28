<x-app-layout>
    <x-slot:header>
        {{ __('Teacher Dashboard') }}
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <x-ui.stat-card 
            :title="__('My Students')" 
            value="{{ $stats['total_students'] }}" 
            icon="users" 
        />
        <x-ui.stat-card 
            :title="__('Today\'s Lessons')" 
            value="{{ $stats['today_lessons'] }}" 
            icon="calendar" 
        />
        <x-ui.stat-card 
            :title="__('Pending Grading')" 
            value="{{ $stats['pending_homework'] }}" 
            icon="document-text" 
            :trend="$stats['pending_homework'] > 0 ? __('Needs attention') : __('All caught up')"
            :trendType="$stats['pending_homework'] > 0 ? 'down' : 'up'"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Today's Lessons -->
        <x-ui.card :header="__('Today\'s Lessons')">
            <div class="space-y-4">
                @forelse($todayLessons as $lesson)
                    <div class="flex items-center justify-between p-4 rounded-xl border {{ $lesson->isLive() ? 'border-red-200 bg-red-50' : 'border-gray-100 bg-gray-50' }}">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-lg bg-white shadow-sm flex items-center justify-center text-center font-bold text-gray-900 leading-tight">
                                {{ $lesson->scheduled_at->format('H:i') }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $lesson->title }}</h4>
                                <p class="text-sm text-gray-500">{{ $lesson->classGroup->name }} • {{ $lesson->classGroup->students()->count() }} {{ __('students') }}</p>
                                @if($lesson->isLive())
                                    <div class="mt-2"><x-ui.live-indicator /></div>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            @if($lesson->isLive())
                                <button class="btn-danger text-sm">{{ __('End Lesson') }}</button>
                            @elseif($lesson->isEnded())
                                <span class="text-sm font-medium text-gray-500">{{ __('Completed') }}</span>
                            @else
                                <button class="btn-primary text-sm">{{ __('Start Lesson') }}</button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <p>{{ __('No lessons scheduled for today.') }}</p>
                    </div>
                @endforelse
            </div>
        </x-ui.card>

        <!-- Recent Submissions -->
        <x-ui.card :header="__('Recent Submissions to Grade')">
            <div class="space-y-4">
                @forelse($recentSubmissions as $submission)
                    <div class="flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:border-accent hover:shadow-sm transition-all">
                        <div class="flex items-center gap-3">
                            <img src="{{ $submission->student->user->avatar_url }}" alt="" class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-medium text-gray-900">{{ $submission->student->user->name }}</p>
                                <p class="text-sm text-gray-500 truncate max-w-[200px]">{{ $submission->homework->title }}</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <p class="text-xs text-gray-400 mb-1">{{ $submission->submitted_at->diffForHumans() }}</p>
                            <a href="#" class="text-sm font-medium text-accent hover:text-accent-hover">{{ __('Grade') }} &rarr;</a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <p>{{ __('All caught up on grading!') }}</p>
                    </div>
                @endforelse
            </div>
        </x-ui.card>
    </div>
</x-app-layout>
