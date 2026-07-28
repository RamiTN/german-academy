<x-app-layout>
    <x-slot:header>{{ __('My Homework') }}</x-slot>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Homework') }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ __('View and submit your homework assignments.') }}</p>
        </div>
    </div>

    <x-ui.card>
        @if(isset($homeworks) && count($homeworks) > 0)
            <div class="p-6 space-y-4">
                @foreach($homeworks as $hw)
                    <div class="p-4 rounded-xl border border-gray-100 bg-gray-50/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">{{ $hw->title }}</h3>
                            <p class="text-gray-600 text-sm mt-1">{{ $hw->instructions }}</p>
                            <p class="text-xs text-gray-400 mt-2">{{ __('Due') }}: {{ $hw->deadline ? $hw->deadline->format('M d, Y H:i') : '' }}</p>
                        </div>
                        <button class="btn-primary text-sm py-2 px-4 shrink-0">{{ __('Submit Assignment') }}</button>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 text-center">
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ __('No pending homework') }}</h3>
                    <p class="text-gray-500 text-sm max-w-sm">{{ __('You have completed all assigned homework.') }}</p>
                </div>
            </div>
        @endif
    </x-ui.card>
</x-app-layout>
