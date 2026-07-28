<x-app-layout>
    <x-slot:header>{{ __('Quizzes') }}</x-slot>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Quizzes') }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ __('Manage quizzes for your classes.') }}</p>
        </div>
        <a href="{{ route('teacher.quizzes.create') }}" class="btn-primary text-sm">
            <svg class="w-4 h-4 me-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            {{ __('Create Quiz') }}
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <x-ui.card>
        @if(isset($quizzes) && count($quizzes) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-start">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3">{{ __('Title') }}</th>
                            <th class="px-4 py-3">{{ __('Class Group') }}</th>
                            <th class="px-4 py-3">{{ __('Time Limit') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quizzes as $quiz)
                            <tr class="border-b border-gray-100 hover:bg-gray-50/50">
                                <td class="px-4 py-3 font-semibold text-gray-900">{{ $quiz->title }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $quiz->classGroup->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $quiz->time_limit_minutes }} mins</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-8 text-center">
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ __('No quizzes available') }}</h3>
                    <p class="text-gray-500 text-sm max-w-sm mb-4">{{ __('Create quizzes to assess your students.') }}</p>
                    <a href="{{ route('teacher.quizzes.create') }}" class="btn-primary text-sm py-2 px-4">{{ __('Create Quiz') }}</a>
                </div>
            </div>
        @endif
    </x-ui.card>
</x-app-layout>
