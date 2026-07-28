<x-app-layout>
    <x-slot:header>Applications</x-slot>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Student Applications</h2>
            <p class="text-sm text-gray-500 mt-1">Review and manage incoming student applications.</p>
        </div>
        <div class="flex items-center gap-3">
            <select class="input text-sm py-1.5 w-auto">
                <option>All Statuses</option>
                <option>Pending</option>
                <option>Approved</option>
                <option>Rejected</option>
            </select>
        </div>
    </div>

    <x-ui.card>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-start">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3">Applicant</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Level</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" class="px-4 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">No applications yet</h3>
                                <p class="text-gray-500 text-sm max-w-sm">Applications will appear here as prospective students submit them.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </x-ui.card>
</x-app-layout>
