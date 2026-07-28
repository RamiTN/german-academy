<x-app-layout>
    <x-slot:header>{{ __('Create Homework Assignment') }}</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Create Homework Assignment') }}</h2>
            <a href="{{ route('teacher.homework.index') }}" class="btn-secondary text-sm">&larr; {{ __('Back') }}</a>
        </div>

        <x-ui.card class="p-6">
            <form action="{{ route('teacher.homework.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="class_group_id" class="label">{{ __('Class Group') }}</label>
                    <select name="class_group_id" id="class_group_id" required class="input">
                        <option value="" disabled selected>{{ __('Select a Class Group') }}</option>
                        @foreach($classGroups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }} ({{ $group->german_level->value }})</option>
                        @endforeach
                    </select>
                    @error('class_group_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="title" class="label">{{ __('Title') }}</label>
                    <input type="text" name="title" id="title" required class="input" placeholder="e.g. Grammatik Übung Kapitel 3">
                    @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="instructions" class="label">{{ __('Instructions') }}</label>
                    <textarea name="instructions" id="instructions" rows="5" required class="input" placeholder="Describe the assignment steps..."></textarea>
                    @error('instructions')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="deadline" class="label">{{ __('Deadline') }}</label>
                        <input type="datetime-local" name="deadline" id="deadline" required class="input">
                        @error('deadline')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="max_score" class="label">{{ __('Max Score') }}</label>
                        <input type="number" name="max_score" id="max_score" value="100" class="input">
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="btn-primary py-2.5 px-6">{{ __('Create Assignment') }}</button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-app-layout>
