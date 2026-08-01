<x-app-layout>
    <x-slot:header>{{ __('Edit Class Group') }}</x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('teacher.class-groups.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition-colors inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                {{ __('Back to Class Groups') }}
            </a>
            <h2 class="text-2xl font-bold text-gray-900 mt-2">{{ __('Edit:') }} {{ $classGroup->name }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ __('Update group details and manage student enrollment.') }}</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm">
                <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left Column: Group Details Form --}}
            <div class="lg:col-span-2 space-y-6">
                <x-ui.card>
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </div>
                        <h3 class="font-bold text-gray-900">{{ __('Group Details') }}</h3>
                    </div>

                    <form action="{{ route('teacher.class-groups.update', $classGroup) }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('Group Name') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $classGroup->name) }}" required
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                            @error('name')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="german_level" class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('German Level') }} <span class="text-red-500">*</span></label>
                                <select name="german_level" id="german_level" required
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white">
                                    @foreach($levels as $level)
                                        <option value="{{ $level->value }}" {{ old('german_level', $classGroup->german_level->value ?? '') === $level->value ? 'selected' : '' }}>
                                            {{ $level->label() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('german_level')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="max_students" class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('Max Students') }} <span class="text-red-500">*</span></label>
                                <input type="number" name="max_students" id="max_students" value="{{ old('max_students', $classGroup->max_students) }}" required min="1" max="100"
                                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                                @error('max_students')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('Description') }}</label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors resize-none"
                                placeholder="{{ __('Brief description...') }}">{{ old('description', $classGroup->description) }}</textarea>
                            @error('description')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-3">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $classGroup->is_active) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300/30 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                            <div>
                                <span class="text-sm font-semibold text-gray-700">{{ __('Active') }}</span>
                                <p class="text-xs text-gray-500">{{ __('Only active groups can have new meetings and students.') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                            <button type="submit" class="btn-primary text-sm py-2 px-6 inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                {{ __('Save Changes') }}
                            </button>
                        </div>
                    </form>
                </x-ui.card>

                {{-- Student Management --}}
                <x-ui.card>
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <h3 class="font-bold text-gray-900">{{ __('Students') }}</h3>
                            <span class="text-xs text-gray-500">({{ $classGroup->students->count() }} / {{ $classGroup->max_students }})</span>
                        </div>
                    </div>

                    {{-- Add Student Form --}}
                    @if($availableStudents->count() > 0 && !$classGroup->isFull())
                        <form action="{{ route('teacher.class-groups.add-student', $classGroup) }}" method="POST" class="mb-5 p-4 bg-blue-50/50 rounded-xl border border-blue-100">
                            @csrf
                            <label class="block text-xs font-semibold text-blue-700 uppercase tracking-wider mb-2">{{ __('Add Student to Group') }}</label>
                            <div class="flex gap-2">
                                <select name="student_id" required class="flex-1 border border-blue-200 rounded-lg px-3 py-2 text-sm bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    <option value="">{{ __('Select a student...') }}</option>
                                    @foreach($availableStudents as $student)
                                        <option value="{{ $student->id }}">
                                            {{ $student->user->name }} ({{ $student->user->email }}) {{ $student->german_level ? '— ' . $student->german_level->value : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn-primary text-sm py-2 px-4 shrink-0 inline-flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                    {{ __('Add') }}
                                </button>
                            </div>
                        </form>
                    @elseif($classGroup->isFull())
                        <div class="mb-5 p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            {{ __('This class group is full. Increase the max students or remove a student to add more.') }}
                        </div>
                    @endif

                    {{-- Current Students List --}}
                    @if($classGroup->students->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-4 py-3 text-start">{{ __('Student') }}</th>
                                        <th class="px-4 py-3 text-start">{{ __('Email') }}</th>
                                        <th class="px-4 py-3 text-start">{{ __('Level') }}</th>
                                        <th class="px-4 py-3 text-start">{{ __('Enrolled') }}</th>
                                        <th class="px-4 py-3 text-end">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($classGroup->students as $student)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3">
                                                <div class="flex items-center gap-3">
                                                    <img src="{{ $student->user->avatar_url }}" alt="{{ $student->user->name }}" class="w-8 h-8 rounded-full object-cover">
                                                    <span class="font-medium text-gray-900">{{ $student->user->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-gray-600">{{ $student->user->email }}</td>
                                            <td class="px-4 py-3">
                                                @if($student->german_level)
                                                    <x-ui.badge color="{{ $student->german_level->color() }}">{{ $student->german_level->value }}</x-ui.badge>
                                                @else
                                                    <span class="text-xs text-gray-400">—</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-gray-500 text-xs">
                                                {{ $student->enrollment_date ? $student->enrollment_date->format('M d, Y') : __('N/A') }}
                                            </td>
                                            <td class="px-4 py-3 text-end">
                                                <form action="{{ route('teacher.class-groups.remove-student', [$classGroup, $student]) }}" method="POST" 
                                                    onsubmit="return confirm('{{ __('Remove this student from the class group?') }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium transition-colors inline-flex items-center gap-1">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"/></svg>
                                                        {{ __('Remove') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-8 text-center">
                            <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1">{{ __('No Students Yet') }}</h4>
                            <p class="text-xs text-gray-500 max-w-sm mx-auto">{{ __('Use the dropdown above to add students who are not yet assigned to any class group.') }}</p>
                        </div>
                    @endif
                </x-ui.card>
            </div>

            {{-- Right Column: Quick Info & Recent Meetings --}}
            <div class="space-y-6">
                {{-- Quick Stats --}}
                <x-ui.card>
                    <h3 class="font-bold text-gray-900 mb-4 text-sm uppercase tracking-wider text-gray-500">{{ __('Overview') }}</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">{{ __('Students') }}</span>
                            <span class="font-bold text-gray-900">{{ $classGroup->students->count() }} / {{ $classGroup->max_students }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all" style="width: {{ $classGroup->max_students > 0 ? min(($classGroup->students->count() / $classGroup->max_students) * 100, 100) : 0 }}%"></div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">{{ __('Level') }}</span>
                            <x-ui.badge color="{{ $classGroup->german_level->color() }}">{{ $classGroup->german_level->label() }}</x-ui.badge>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">{{ __('Status') }}</span>
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $classGroup->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $classGroup->is_active ? __('Active') : __('Inactive') }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">{{ __('Created') }}</span>
                            <span class="text-sm text-gray-900">{{ $classGroup->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </x-ui.card>

                {{-- Quick Actions --}}
                <x-ui.card>
                    <h3 class="font-bold text-sm uppercase tracking-wider text-gray-500 mb-4">{{ __('Quick Actions') }}</h3>
                    <div class="space-y-2">
                        <a href="{{ route('meetings.create') }}" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                            <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            {{ __('Schedule a Lesson') }}
                        </a>
                        <a href="{{ route('teacher.classrooms.index') }}" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-colors">
                            <svg class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ __('View All Lessons') }}
                        </a>
                    </div>
                </x-ui.card>

                {{-- Recent Meetings --}}
                @if($classGroup->meetings->count() > 0)
                    <x-ui.card>
                        <h3 class="font-bold text-sm uppercase tracking-wider text-gray-500 mb-4">{{ __('Recent Meetings') }}</h3>
                        <div class="space-y-3">
                            @foreach($classGroup->meetings as $meeting)
                                <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                                    <div class="w-9 h-9 rounded-lg bg-white border border-gray-200 flex flex-col items-center justify-center text-[10px] font-bold shrink-0">
                                        <span class="text-blue-600 leading-none">{{ $meeting->scheduled_at ? $meeting->scheduled_at->format('M') : '' }}</span>
                                        <span class="text-gray-900 text-xs leading-none">{{ $meeting->scheduled_at ? $meeting->scheduled_at->format('d') : '' }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $meeting->title }}</p>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded-full {{ $meeting->status->value === 'live' ? 'bg-red-100 text-red-700' : ($meeting->status->value === 'scheduled' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600') }}">
                                                {{ $meeting->status->label() }}
                                            </span>
                                            @if($meeting->meet_link)
                                                <span class="text-[10px] text-green-600">✓ {{ __('Meet Link') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-ui.card>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
