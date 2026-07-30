<x-app-layout>
    <x-slot:header>{{ __('Schedule New Meeting') }}</x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ __('Schedule New Lesson Meeting') }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ __('Set up a title, select a class group, and pick the scheduled time. You can attach a Google Meet link later.') }}</p>
            </div>
            <a href="{{ auth()->user()->isTeacher() ? route('teacher.classrooms.index') : route('admin.schedules.index') }}" class="btn-secondary text-sm">
                &larr; {{ __('Back to Classrooms') }}
            </a>
        </div>

        @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
            </div>
        @endif

        <x-ui.card>
            <form action="{{ route('meetings.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="title" class="label font-medium text-gray-700">{{ __('Lesson Title') }} <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" class="input mt-1" value="{{ old('title') }}" placeholder="{{ __('e.g., Chapter 3: German Grammar & Vocabulary Practice') }}" required>
                    @error('title')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="class_group_id" class="label font-medium text-gray-700">{{ __('Class Group') }} <span class="text-red-500">*</span></label>
                    <select name="class_group_id" id="class_group_id" class="input mt-1" required>
                        <option value="">{{ __('-- Select Class Group --') }}</option>
                        @foreach($classGroups as $group)
                            <option value="{{ $group->id }}" @selected(old('class_group_id') == $group->id)>
                                {{ $group->name }} ({{ $group->german_level->value ?? $group->german_level }})
                                @if(auth()->user()->isAdmin() && $group->teacher)
                                    - {{ __('Teacher') }}: {{ $group->teacher->user->name ?? '' }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @if($classGroups->isEmpty())
                        <p class="text-xs text-amber-600 mt-1.5 flex items-center gap-1">
                            <svg class="w-4 h-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            {{ __('No active class groups found. Please make sure class groups exist and have a teacher assigned.') }}
                        </p>
                    @endif
                    @error('class_group_id')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="scheduled_at" class="label font-medium text-gray-700">{{ __('Scheduled Date & Time') }} <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="input mt-1" value="{{ old('scheduled_at') }}" required>
                    @error('scheduled_at')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="notes" class="label font-medium text-gray-700">{{ __('Lesson Notes / Agenda (Optional)') }}</label>
                    <textarea name="notes" id="notes" rows="4" class="input mt-1" placeholder="{{ __('Optional instructions or topics covered in this lesson...') }}">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                    <a href="{{ auth()->user()->isTeacher() ? route('teacher.classrooms.index') : route('admin.schedules.index') }}" class="btn-secondary">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="btn-primary px-6" @disabled($classGroups->isEmpty())>
                        {{ __('Schedule Meeting') }}
                    </button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-app-layout>
