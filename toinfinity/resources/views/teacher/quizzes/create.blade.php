<x-app-layout>
    <x-slot:header>{{ __('Create Quiz') }}</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Create Quiz') }}</h2>
            <a href="{{ route('teacher.quizzes.index') }}" class="btn-secondary text-sm">&larr; {{ __('Back') }}</a>
        </div>

        <x-ui.card class="p-6">
            <form action="{{ route('teacher.quizzes.store') }}" method="POST" class="space-y-6">
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
                    <label for="title" class="label">{{ __('Quiz Title') }}</label>
                    <input type="text" name="title" id="title" required class="input" placeholder="e.g. Wortschatz Quiz 1">
                    @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="description" class="label">{{ __('Description') }}</label>
                    <textarea name="description" id="description" rows="3" class="input" placeholder="Short description of the quiz..."></textarea>
                </div>

                <div>
                    <label for="time_limit_minutes" class="label">{{ __('Time Limit (Minutes)') }}</label>
                    <input type="number" name="time_limit_minutes" id="time_limit_minutes" value="15" class="input">
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="btn-primary py-2.5 px-6">{{ __('Create Quiz') }}</button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-app-layout>
