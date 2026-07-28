<x-app-layout>
    <x-slot:header>System Logs</x-slot>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Activity Logs</h2>
            <p class="text-sm text-gray-500 mt-1">Monitor system events and user activity.</p>
        </div>
        <button class="btn-secondary text-sm">
            Export Logs
        </button>
    </div>

    <x-ui.card>
        <div class="p-8 text-center">
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-1">No logs recorded</h3>
                <p class="text-gray-500 text-sm max-w-sm">System activity will be recorded here.</p>
            </div>
        </div>
    </x-ui.card>
</x-app-layout>
