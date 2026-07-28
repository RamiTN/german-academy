<x-app-layout>
    <x-slot:header>Applications</x-slot>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Student Applications</h2>
            <p class="text-sm text-gray-500 mt-1">Review and update incoming applications.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <x-ui.card>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-start">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3">Applicant</th>
                        <th class="px-4 py-3">Level</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $application)
                        <tr class="border-b border-gray-100 hover:bg-gray-50/50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $application->name }}<br><span class="text-gray-500 text-xs font-normal">{{ $application->email }}</span></td>
                            <td class="px-4 py-3"><x-ui.badge color="{{ $application->german_level->color() }}">{{ $application->german_level->value }}</x-ui.badge></td>
                            <td class="px-4 py-3"><x-ui.badge color="{{ $application->status->color() }}">{{ $application->status->label() }}</x-ui.badge></td>
                            <td class="px-4 py-3 text-gray-500">{{ $application->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-end">
                                <a href="{{ route('teacher.applications.edit', $application) }}" class="text-accent hover:text-accent-hover font-medium text-sm">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">No applications</h3>
                                    <p class="text-gray-500 text-sm max-w-sm">There are currently no applications to review.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($applications->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $applications->links() }}
            </div>
        @endif
    </x-ui.card>
</x-app-layout>
