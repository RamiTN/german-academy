<x-app-layout>
    <x-slot:header>Edit Application</x-slot>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Review Application</h2>
            <p class="text-sm text-gray-500 mt-1">Review applicant details and update their status.</p>
        </div>
        <a href="{{ route('teacher.applications.index') }}" class="btn-secondary text-sm">
            &larr; Back to Applications
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <x-ui.card header="Applicant Details">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Full Name</p>
                            <p class="font-semibold text-gray-900">{{ $application->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Email Address</p>
                            <p class="font-semibold text-gray-900">{{ $application->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Phone Number</p>
                            <p class="font-semibold text-gray-900">{{ $application->phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Desired Level</p>
                            <p class="font-semibold text-gray-900"><x-ui.badge color="{{ $application->german_level->color() }}">{{ $application->german_level->value }}</x-ui.badge></p>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-500 font-medium mb-1">Previous Experience</p>
                        <p class="text-gray-900">{{ $application->previous_experience ?: 'None provided.' }}</p>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-500 font-medium mb-1">Goals</p>
                        <p class="text-gray-900">{{ $application->goals ?: 'None provided.' }}</p>
                    </div>
                </div>
            </x-ui.card>
        </div>
        
        <div>
            <x-ui.card header="Update Status">
                <form action="{{ route('teacher.applications.update', $application) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="status" class="label">Status</label>
                        <select name="status" id="status" class="input">
                            <option value="pending" @selected($application->status->value === 'pending')>Pending</option>
                            <option value="approved" @selected($application->status->value === 'approved')>Approved</option>
                            <option value="rejected" @selected($application->status->value === 'rejected')>Rejected</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="notes" class="label">Internal Notes (Optional)</label>
                        <textarea name="notes" id="notes" rows="4" class="input">{{ old('notes', $application->notes) }}</textarea>
                    </div>
                    
                    <div class="pt-2">
                        <button type="submit" class="btn-primary w-full">Save Changes</button>
                    </div>
                </form>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
