<x-app-layout>
    <x-slot:header>My Grades</x-slot>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Grades & Progress</h2>
            <p class="text-sm text-gray-500 mt-1">Track your performance across homework, quizzes, and tests.</p>
        </div>
    </div>

    <x-ui.card>
        <div class="p-8 text-center">
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-1">No grades yet</h3>
                <p class="text-gray-500 text-sm max-w-sm">Complete assignments and tests to see your grades here.</p>
            </div>
        </div>
    </x-ui.card>
</x-app-layout>
