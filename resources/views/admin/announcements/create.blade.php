<x-app-layout>
    <x-slot:header>{{ __('New Announcement') }}</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">{{ __('New Announcement') }}</h2>
            <a href="{{ route('admin.announcements.index') }}" class="btn-secondary text-sm">&larr; {{ __('Back') }}</a>
        </div>

        <x-ui.card class="p-6">
            <form action="{{ route('admin.announcements.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="class_group_id" class="label">{{ __('Class Group') }}</label>
                    <select name="class_group_id" id="class_group_id" class="input">
                        <option value="">{{ __('All Classes (Global)') }}</option>
                        @foreach($classGroups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }} ({{ $group->german_level->value }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="title" class="label">{{ __('Announcement Title') }}</label>
                    <input type="text" name="title" id="title" required class="input">
                </div>

                <div>
                    <label for="content" class="label">{{ __('Content') }}</label>
                    <textarea name="content" id="content" rows="5" required class="input"></textarea>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_pinned" id="is_pinned" value="1" class="rounded border-gray-300 text-accent focus:ring-accent">
                    <label for="is_pinned" class="text-sm font-medium text-gray-700">{{ __('Pin this announcement to top') }}</label>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="btn-primary py-2.5 px-6">{{ __('Post Announcement') }}</button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-app-layout>
