<x-app-layout>
    <x-slot:header>{{ __('Upload Resource') }}</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Upload Resource') }}</h2>
            <a href="{{ route('teacher.resources.index') }}" class="btn-secondary text-sm">&larr; {{ __('Back') }}</a>
        </div>

        <x-ui.card class="p-6">
            <form action="{{ route('teacher.resources.store') }}" method="POST" class="space-y-6">
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
                    <label for="title" class="label">{{ __('Resource Title') }}</label>
                    <input type="text" name="title" id="title" required class="input" placeholder="e.g. A1 Vocabulary List PDF">
                    @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="type" class="label">{{ __('Resource Type') }}</label>
                    <select name="type" id="type" required class="input">
                        <option value="pdf">PDF Document</option>
                        <option value="ppt">Presentation (PPT)</option>
                        <option value="image">Image</option>
                        <option value="video">Video Link</option>
                        <option value="link">External Website Link</option>
                    </select>
                </div>

                <div>
                    <label for="external_url" class="label">{{ __('Resource URL / Link') }}</label>
                    <input type="url" name="external_url" id="external_url" class="input" placeholder="https://example.com/file.pdf">
                </div>

                <div>
                    <label for="description" class="label">{{ __('Description') }}</label>
                    <textarea name="description" id="description" rows="3" class="input" placeholder="Brief description of the material..."></textarea>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="btn-primary py-2.5 px-6">{{ __('Upload Resource') }}</button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-app-layout>
