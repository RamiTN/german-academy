<x-app-layout>
    <x-slot:header>My Students</x-slot>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">My Students</h2>
            <p class="text-sm text-gray-500 mt-1">View students enrolled in your class groups.</p>
        </div>
    </div>

    <x-ui.card>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-start">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3">Student</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Level</th>
                        <th class="px-4 py-3">Class Group</th>
                        <th class="px-4 py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop through students here once data is passed --}}
                    {{-- Example empty state --}}
                    <tr>
                        <td colspan="5" class="px-4 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">No students assigned</h3>
                                <p class="text-gray-500 text-sm max-w-sm">You have no students assigned to your class groups yet.</p>
                            </div>
                        </td>
                    </tr>
                    {{-- Example row format for later:
                    <tr>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Level</td>
                        <td>Group</td>
                        <td class="text-end">
                            <form action="{{ route('teacher.students.destroy', 1) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this student?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Remove</button>
                            </form>
                        </td>
                    </tr>
                    --}}
                </tbody>
            </table>
        </div>
    </x-ui.card>
</x-app-layout>
