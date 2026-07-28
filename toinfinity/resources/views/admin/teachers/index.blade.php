<x-app-layout>
    <x-slot:header>{{ __('Teachers') }}</x-slot>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('All Teachers') }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ __('Manage your teaching staff and their class assignments.') }}</p>
        </div>
        <button class="btn-primary text-sm">
            <svg class="w-4 h-4 me-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            {{ __('Add Teacher') }}
        </button>
    </div>

    <x-ui.card>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-start">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3">{{ __('Teacher') }}</th>
                        <th class="px-4 py-3">{{ __('Email') }}</th>
                        <th class="px-4 py-3">{{ __('Specializations') }}</th>
                        <th class="px-4 py-3 text-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4" class="px-4 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 13.5a3 3 0 100-6 3 3 0 000 6z" /></svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ __('No teachers yet') }}</h3>
                                <p class="text-gray-500 text-sm max-w-sm">{{ __('Teachers will appear here once they are registered and approved.') }}</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </x-ui.card>
</x-app-layout>
