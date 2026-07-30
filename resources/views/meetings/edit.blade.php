<x-app-layout>
    <x-slot:header>{{ __('Edit Meeting & Google Meet Link') }}</x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ __('Live Lesson Link & Status') }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ __('Paste your Google Meet URL so students can join. Update status to "Live Now" when starting the call.') }}</p>
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

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
                <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <x-ui.card>
            <form action="{{ route('meetings.update', $meeting) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="label font-medium text-gray-700">{{ __('Lesson Title') }} <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" class="input mt-1" value="{{ old('title', $meeting->title) }}" required>
                    @error('title')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="label font-medium text-gray-700">{{ __('Class Group') }}</label>
                    <input type="text" class="input mt-1 bg-gray-50 cursor-not-allowed" value="{{ $meeting->classGroup->name ?? 'N/A' }} ({{ $meeting->classGroup->german_level->value ?? 'N/A' }})" disabled>
                </div>

                <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-4">
                    <label for="meet_link" class="label font-semibold text-blue-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        {{ __('Google Meet URL') }}
                    </label>
                    <p class="text-xs text-blue-700 mb-2">{{ __('Paste the exact Google Meet link (e.g. https://meet.google.com/abc-defg-hij). Students will see a "Join Meet" button.') }}</p>
                    <input type="url" name="meet_link" id="meet_link" class="input bg-white" value="{{ old('meet_link', $meeting->meet_link) }}" placeholder="https://meet.google.com/abc-defg-hij">
                    @error('meet_link')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="label font-medium text-gray-700">{{ __('Meeting Status') }} <span class="text-red-500">*</span></label>
                        <select name="status" id="status" class="input mt-1" required>
                            <option value="scheduled" @selected(old('status', $meeting->status->value ?? $meeting->status) === 'scheduled')>{{ __('Scheduled') }}</option>
                            <option value="live" @selected(old('status', $meeting->status->value ?? $meeting->status) === 'live')>{{ __('Live Now (Red Indicator)') }}</option>
                            <option value="ended" @selected(old('status', $meeting->status->value ?? $meeting->status) === 'ended')>{{ __('Ended') }}</option>
                            <option value="cancelled" @selected(old('status', $meeting->status->value ?? $meeting->status) === 'cancelled')>{{ __('Cancelled') }}</option>
                        </select>
                        @error('status')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="scheduled_at" class="label font-medium text-gray-700">{{ __('Scheduled Date & Time') }} <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="input mt-1" value="{{ old('scheduled_at', $meeting->scheduled_at ? $meeting->scheduled_at->format('Y-m-d\TH:i') : '') }}" required>
                        @error('scheduled_at')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="notes" class="label font-medium text-gray-700">{{ __('Lesson Notes / Description') }}</label>
                    <textarea name="notes" id="notes" rows="4" class="input mt-1" placeholder="{{ __('Notes or topic agenda for this meeting...') }}">{{ old('notes', $meeting->notes) }}</textarea>
                    @error('notes')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                    <div>
                        @if($meeting->meet_link)
                            <a href="{{ route('meetings.join', $meeting) }}" target="_blank" class="btn bg-red-600 text-white hover:bg-red-700 text-sm font-semibold inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                {{ __('Test Join Link') }} &rarr;
                            </a>
                        @endif
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ auth()->user()->isTeacher() ? route('teacher.classrooms.index') : route('admin.schedules.index') }}" class="btn-secondary">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="btn-primary px-6">
                            {{ __('Save Meeting Details') }}
                        </button>
                    </div>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-app-layout>
