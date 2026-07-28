<x-app-layout>
    <x-slot:header>{{ __('Learning Resources') }}</x-slot>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Learning Resources') }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ __('Share materials and resources with your classes.') }}</p>
        </div>
        <a href="{{ route('teacher.resources.create') }}" class="btn-primary text-sm">
            <svg class="w-4 h-4 me-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            {{ __('Upload Resource') }}
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <x-ui.card>
        @if(isset($resources) && count($resources) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-start">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3">{{ __('Title') }}</th>
                            <th class="px-4 py-3">{{ __('Type') }}</th>
                            <th class="px-4 py-3">{{ __('Class Group') }}</th>
                            <th class="px-4 py-3 text-end">{{ __('Link') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resources as $res)
                            <tr class="border-b border-gray-100 hover:bg-gray-50/50">
                                <td class="px-4 py-3 font-semibold text-gray-900">{{ $res->title }}</td>
                                <td class="px-4 py-3 text-gray-500 uppercase text-xs font-bold">{{ $res->type }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $res->classGroup->name ?? 'All Classes' }}</td>
                                <td class="px-4 py-3 text-end">
                                    <a href="{{ $res->external_url }}" target="_blank" class="text-accent hover:underline text-xs font-semibold">Open &rarr;</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-8 text-center">
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" /></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ __('No resources uploaded') }}</h3>
                    <p class="text-gray-500 text-sm max-w-sm mb-4">{{ __('Upload files and links to share with your students.') }}</p>
                    <a href="{{ route('teacher.resources.create') }}" class="btn-primary text-sm py-2 px-4">{{ __('Upload Resource') }}</a>
                </div>
            </div>
        @endif
    </x-ui.card>
</x-app-layout>
