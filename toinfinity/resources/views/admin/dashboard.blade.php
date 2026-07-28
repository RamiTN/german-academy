<x-app-layout>
    <x-slot:header>
        {{ __('Dashboard') }}
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-ui.stat-card 
            :title="__('Total Students')" 
            value="{{ $stats['total_students'] }}" 
            icon="users" 
            trend="+12%" 
            trendType="up" 
        />
        <x-ui.stat-card 
            :title="__('Active Teachers')" 
            value="{{ $stats['total_teachers'] }}" 
            icon="academic-cap" 
        />
        <x-ui.stat-card 
            :title="__('Pending Applications')" 
            value="{{ $stats['pending_applications'] }}" 
            icon="document-text" 
        />
        <x-ui.stat-card 
            :title="__('Today\'s Lessons')" 
            value="{{ $stats['today_lessons'] }}" 
            icon="calendar" 
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <x-ui.card :header="__('Recent Applications')">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-start">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3">{{ __('Name') }}</th>
                                <th class="px-4 py-3">{{ __('Level') }}</th>
                                <th class="px-4 py-3">{{ __('Date') }}</th>
                                <th class="px-4 py-3">{{ __('Status') }}</th>
                                <th class="px-4 py-3 text-end">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentApplications as $app)
                                <tr class="border-b border-gray-100 hover:bg-gray-50/50">
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $app->name }}</td>
                                    <td class="px-4 py-3"><x-ui.badge color="{{ $app->german_level->color() }}">{{ $app->german_level->value }}</x-ui.badge></td>
                                    <td class="px-4 py-3 text-gray-500">{{ $app->created_at->format('M d, Y') }}</td>
                                    <td class="px-4 py-3"><x-ui.badge color="{{ $app->status->color() }}">{{ $app->status->label() }}</x-ui.badge></td>
                                    <td class="px-4 py-3 text-end">
                                        <a href="{{ route('admin.applications.index') }}" class="text-accent hover:text-accent-hover font-medium">{{ __('Review') }}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-500">{{ __('No recent applications.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-ui.card>
        </div>
        
        <div>
            <x-ui.card :header="__('Quick Actions')">
                <div class="space-y-3">
                    <a href="{{ route('admin.homework.create') }}" class="flex items-center p-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50 border border-gray-100 group">
                        <div class="w-8 h-8 rounded-md bg-green-100 text-green-600 flex items-center justify-center me-3 group-hover:bg-green-200 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        </div>
                        {{ __('Create Assignment') }}
                    </a>
                    <a href="{{ route('admin.quizzes.create') }}" class="flex items-center p-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50 border border-gray-100 group">
                        <div class="w-8 h-8 rounded-md bg-blue-100 text-blue-600 flex items-center justify-center me-3 group-hover:bg-blue-200 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        </div>
                        {{ __('Create Quiz') }}
                    </a>
                    <a href="{{ route('admin.announcements.create') }}" class="flex items-center p-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-50 border border-gray-100 group">
                        <div class="w-8 h-8 rounded-md bg-purple-100 text-purple-600 flex items-center justify-center me-3 group-hover:bg-purple-200 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg>
                        </div>
                        {{ __('Post Announcement') }}
                    </a>
                </div>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
