<x-app-layout>
    <x-slot:header>{{ __('My Quizzes') }}</x-slot>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Quizzes') }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ __('Take quizzes and view your results.') }}</p>
        </div>
    </div>

    <x-ui.card>
        @if(isset($quizzes) && count($quizzes) > 0)
            <div class="p-6 space-y-4">
                @foreach($quizzes as $quiz)
                    <div class="p-4 rounded-xl border border-gray-100 bg-gray-50/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">{{ $quiz->title }}</h3>
                            <p class="text-gray-600 text-sm mt-1">{{ $quiz->description }}</p>
                            <p class="text-xs text-gray-400 mt-2">{{ __('Time Limit') }}: {{ $quiz->time_limit_minutes }} {{ __('mins') }}</p>
                        </div>
                        <button class="btn-primary text-sm py-2 px-4 shrink-0">{{ __('Start Quiz') }}</button>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 text-center">
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ __('No pending quizzes') }}</h3>
                    <p class="text-gray-500 text-sm max-w-sm">{{ __('You have no new quizzes to complete.') }}</p>
                </div>
            </div>
        @endif
    </x-ui.card>
</x-app-layout>
