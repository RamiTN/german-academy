<x-app-layout>
    <x-slot:header>{{ __('Applications') }}</x-slot>

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Student Applications') }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ __('Review and approve incoming student applications and assign them to class groups.') }}</p>
        </div>
        <div>
            <form method="GET" action="{{ route('admin.applications.index') }}" class="flex items-center gap-3">
                <select name="status" onchange="this.form.submit()" class="input text-sm py-1.5 w-auto">
                    <option value="">{{ __('All Statuses') }}</option>
                    <option value="pending" @selected(request('status') === 'pending')>{{ __('Pending') }}</option>
                    <option value="approved" @selected(request('status') === 'approved')>{{ __('Approved') }}</option>
                    <option value="rejected" @selected(request('status') === 'rejected')>{{ __('Rejected') }}</option>
                </select>
            </form>
        </div>
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

    <x-ui.card>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-start">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3">{{ __('Applicant') }}</th>
                        <th class="px-4 py-3">{{ __('Email & Phone') }}</th>
                        <th class="px-4 py-3">{{ __('Requested Level') }}</th>
                        <th class="px-4 py-3">{{ __('Applied Date') }}</th>
                        <th class="px-4 py-3">{{ __('Status') }}</th>
                        <th class="px-4 py-3 text-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($applications as $app)
                        <tr class="hover:bg-gray-50/70 transition-colors">
                            <td class="px-4 py-3 font-semibold text-gray-900">{{ $app->name }}</td>
                            <td class="px-4 py-3 text-gray-600">
                                <div>{{ $app->email }}</div>
                                <div class="text-xs text-gray-400">{{ $app->phone ?: __('No phone') }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <x-ui.badge color="{{ $app->german_level->color() }}">{{ $app->german_level->value }}</x-ui.badge>
                            </td>
                            <td class="px-4 py-3 text-gray-500 text-xs">
                                {{ $app->created_at->format('Y-m-d') }} ({{ $app->created_at->diffForHumans() }})
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $app->status->value === 'approved' ? 'bg-green-100 text-green-700' : ($app->status->value === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                    {{ $app->status->label() }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-end">
                                <a href="{{ route('admin.applications.edit', $app) }}" class="btn-primary text-xs py-1 px-3 inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    {{ __('Review / Approve') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ __('No applications found') }}</h3>
                                    <p class="text-gray-500 text-sm max-w-sm">{{ __('Applications will appear here as prospective students submit them.') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($applications->hasPages())
            <div class="mt-4 border-t border-gray-100 pt-4">
                {{ $applications->links() }}
            </div>
        @endif
    </x-ui.card>
</x-app-layout>
