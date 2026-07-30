<x-app-layout>
    <x-slot:header>{{ __('Create Class Group') }}</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('teacher.class-groups.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition-colors inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                {{ __('Back to Class Groups') }}
            </a>
            <h2 class="text-2xl font-bold text-gray-900 mt-2">{{ __('Create New Class Group') }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ __('Set up a new class group for your students. You can add students after creation.') }}</p>
        </div>

        @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
            </div>
        @endif

        <x-ui.card>
            <form action="{{ route('teacher.class-groups.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Group Name --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('Group Name') }} <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors"
                        placeholder="{{ __('e.g. Morning Group A1, Evening B2 Class') }}">
                    @error('name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- German Level --}}
                <div>
                    <label for="german_level" class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('German Level') }} <span class="text-red-500">*</span></label>
                    <select name="german_level" id="german_level" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors bg-white">
                        <option value="">{{ __('Select level...') }}</option>
                        @foreach($levels as $level)
                            <option value="{{ $level->value }}" {{ old('german_level') === $level->value ? 'selected' : '' }}>
                                {{ $level->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('german_level')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('Description') }}</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors resize-none"
                        placeholder="{{ __('Brief description of the class group, schedule, or focus areas...') }}">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Max Students --}}
                <div>
                    <label for="max_students" class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('Maximum Students') }} <span class="text-red-500">*</span></label>
                    <input type="number" name="max_students" id="max_students" value="{{ old('max_students', 20) }}" required min="1" max="100"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                    @error('max_students')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Active Toggle --}}
                <div class="flex items-center gap-3">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', true) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300/30 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                    <div>
                        <span class="text-sm font-semibold text-gray-700">{{ __('Active') }}</span>
                        <p class="text-xs text-gray-500">{{ __('Only active groups can have new meetings and students.') }}</p>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('teacher.class-groups.index') }}" class="btn-secondary text-sm py-2 px-4">{{ __('Cancel') }}</a>
                    <button type="submit" class="btn-primary text-sm py-2 px-6 inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        {{ __('Create Class Group') }}
                    </button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-app-layout>
