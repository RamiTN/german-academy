<x-app-layout>
    <x-slot:header>Resources</x-slot>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Learning Resources</h2>
            <p class="text-sm text-gray-500 mt-1">Access materials shared by your teachers.</p>
        </div>
    </div>

    <x-ui.card>
        <div class="p-8 text-center">
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" /></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-1">No resources found</h3>
                <p class="text-gray-500 text-sm max-w-sm">Files and links shared by your teachers will appear here.</p>
            </div>
        </div>
    </x-ui.card>
</x-app-layout>
