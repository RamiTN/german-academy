<x-app-layout>
    <x-slot:header>{{ __('Edit Application') }}</x-slot>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Review Application') }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ __('Review applicant details, assign class group, and update status.') }}</p>
        </div>
        <a href="{{ route('teacher.applications.index') }}" class="btn-secondary text-sm">
            &larr; {{ __('Back to Applications') }}
        </a>
    </div>

    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
            <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <x-ui.card header="{{ __('Applicant Details') }}">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">{{ __('Full Name') }}</p>
                            <p class="font-semibold text-gray-900">{{ $application->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">{{ __('Email Address') }}</p>
                            <p class="font-semibold text-gray-900">{{ $application->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">{{ __('Phone Number') }}</p>
                            <p class="font-semibold text-gray-900">{{ $application->phone ?: __('N/A') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">{{ __('Requested Level') }}</p>
                            <p class="font-semibold text-gray-900">
                                <x-ui.badge color="{{ $application->german_level->color() }}">{{ $application->german_level->value }}</x-ui.badge>
                            </p>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-500 font-medium mb-1">{{ __('Preferred Schedule / Message') }}</p>
                        <p class="text-gray-900">{{ $application->message ?: ($application->preferred_schedule ?: __('None provided.')) }}</p>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <div>
            <x-ui.card header="{{ __('Update Application & Approval') }}">
                <form action="{{ route('teacher.applications.update', $application) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="status" class="label font-medium text-gray-700">{{ __('Status') }}</label>
                        <select name="status" id="status" class="input mt-1">
                            <option value="pending" @selected($application->status->value === 'pending')>{{ __('Pending') }}</option>
                            <option value="approved" @selected($application->status->value === 'approved')>{{ __('Approved') }}</option>
                            <option value="rejected" @selected($application->status->value === 'rejected')>{{ __('Rejected') }}</option>
                        </select>
                    </div>

                    <div>
                        <label for="class_group_id" class="label font-medium text-gray-700">{{ __('Assign Class Group') }}</label>
                        <select name="class_group_id" id="class_group_id" class="input mt-1">
                            <option value="">{{ __('-- Select Class Group --') }}</option>
                            @foreach($classGroups as $group)
                                <option value="{{ $group->id }}" @selected(($group->german_level->value ?? $group->german_level) === ($application->german_level->value ?? $application->german_level))>
                                    {{ $group->name }} ({{ $group->german_level->value ?? $group->german_level }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">{{ __('When approving, a student account will automatically be created and assigned to this class group.') }}</p>
                    </div>

                    <div>
                        <label for="notes" class="label font-medium text-gray-700">{{ __('Internal Notes') }}</label>
                        <textarea name="notes" id="notes" rows="4" class="input mt-1">{{ old('notes', $application->admin_notes) }}</textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="btn-primary w-full">{{ __('Save Application Changes') }}</button>
                    </div>
                </form>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
