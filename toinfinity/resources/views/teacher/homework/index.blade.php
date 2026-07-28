<x-app-layout>
    <x-slot:header>{{ __('Homework Assignments') }}</x-slot>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Homework Assignments') }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ __('Assign and grade homework for your students.') }}</p>
        </div>
        <a href="{{ route('teacher.homework.create') }}" class="btn-primary text-sm">
            <svg class="w-4 h-4 me-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            {{ __('Create Assignment') }}
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <x-ui.card>
        @if(isset($homeworks) && count($homeworks) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-start">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3">{{ __('Title') }}</th>
                            <th class="px-4 py-3">{{ __('Class Group') }}</th>
                            <th class="px-4 py-3">{{ __('Deadline') }}</th>
                            <th class="px-4 py-3">{{ __('Max Score') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($homeworks as $hw)
                            <tr class="border-b border-gray-100 hover:bg-gray-50/50">
                                <td class="px-4 py-3 font-semibold text-gray-900">{{ $hw->title }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $hw->classGroup->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $hw->deadline ? $hw->deadline->format('M d, Y H:i') : 'N/A' }}</td>
                                <td class="px-4 py-3 font-bold text-gray-900">{{ $hw->max_score }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-8 text-center">
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ __('No homework assigned yet') }}</h3>
                    <p class="text-gray-500 text-sm max-w-sm mb-4">{{ __('Create homework assignments for your classes.') }}</p>
                    <a href="{{ route('teacher.homework.create') }}" class="btn-primary text-sm py-2 px-4">{{ __('Create Assignment') }}</a>
                </div>
            </div>
        @endif
    </x-ui.card>
</x-app-layout>
