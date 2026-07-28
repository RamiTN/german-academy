<x-app-layout>
    <x-slot:header>My Tests</x-slot>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Module Tests</h2>
            <p class="text-sm text-gray-500 mt-1">Take your end-of-module tests and view results.</p>
        </div>
    </div>

    <x-ui.card>
        <div class="p-8 text-center">
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-1">No upcoming tests</h3>
                <p class="text-gray-500 text-sm max-w-sm">You have no new tests to complete.</p>
            </div>
        </div>
    </x-ui.card>
</x-app-layout>
