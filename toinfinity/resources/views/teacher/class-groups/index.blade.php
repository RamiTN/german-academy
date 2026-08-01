<x-app-layout>
    <x-slot:header>{{ __('My Class Groups') }}</x-slot>

    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('My Class Groups') }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ __('Create and manage your class groups. Add students, schedule lessons, and share Google Meet links.') }}</p>
        </div>
        <div>
            <a href="{{ route('teacher.class-groups.create') }}" class="btn-primary inline-flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('Create New Group') }}
            </a>
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

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($classGroups as $group)
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md hover:border-gray-300 transition-all duration-300 overflow-hidden group">
                {{-- Header --}}
                <div class="p-6 pb-4">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $group->is_active ? 'from-blue-500 to-indigo-600' : 'from-gray-400 to-gray-500' }} text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                {{ strtoupper(substr($group->name, 0, 2)) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg leading-tight">{{ $group->name }}</h3>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <x-ui.badge color="{{ $group->german_level->color() }}">{{ $group->german_level->value }}</x-ui.badge>
                                    @if(!$group->is_active)
                                        <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded bg-gray-100 text-gray-500 uppercase tracking-wide">{{ __('Inactive') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($group->description)
                        <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ $group->description }}</p>
                    @endif

                    {{-- Stats --}}
                    <div class="flex items-center gap-4 text-sm">
                        <div class="flex items-center gap-1.5 text-gray-600">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="font-medium">{{ $group->students_count }}</span>
                            <span class="text-gray-400">/ {{ $group->max_students }}</span>
                        </div>
                        @if($group->meetings->count() > 0)
                            <div class="flex items-center gap-1.5 text-gray-600">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $group->meetings->count() }} {{ __('upcoming') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Upcoming Meetings Preview --}}
                @if($group->meetings->count() > 0)
                    <div class="px-6 py-3 bg-gray-50 border-t border-gray-100">
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-2">{{ __('Next Lessons') }}</p>
                        <div class="space-y-1.5">
                            @foreach($group->meetings->take(2) as $meeting)
                                <div class="flex items-center gap-2 text-xs">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $meeting->status->value === 'live' ? 'bg-red-500 animate-pulse' : 'bg-blue-400' }} shrink-0"></span>
                                    <span class="text-gray-700 font-medium truncate flex-1">{{ $meeting->title }}</span>
                                    <span class="text-gray-400 shrink-0">{{ $meeting->scheduled_at ? $meeting->scheduled_at->format('M d, H:i') : '' }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Actions --}}
                <div class="px-6 py-3 border-t border-gray-100 flex items-center justify-between">
                    <a href="{{ route('teacher.class-groups.edit', $group) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors inline-flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        {{ __('Manage') }}
                    </a>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('meetings.create') }}" class="text-xs font-medium text-gray-500 hover:text-gray-700 transition-colors px-2 py-1 rounded hover:bg-gray-100">
                            {{ __('+ Lesson') }}
                        </a>
                        <form action="{{ route('teacher.class-groups.destroy', $group) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure? This will unassign all students and delete the group.') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-medium text-red-500 hover:text-red-700 transition-colors px-2 py-1 rounded hover:bg-red-50">
                                {{ __('Delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <x-ui.card>
                    <div class="p-12 text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-50 to-indigo-100 rounded-full flex items-center justify-center mx-auto mb-5">
                            <svg class="w-10 h-10 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('No Class Groups Yet') }}</h3>
                        <p class="text-gray-500 max-w-sm mx-auto mb-6">{{ __('Create your first class group to start organizing students, scheduling lessons, and sharing Google Meet links.') }}</p>
                        <a href="{{ route('teacher.class-groups.create') }}" class="btn-primary inline-flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            {{ __('Create First Group') }}
                        </a>
                    </div>
                </x-ui.card>
            </div>
        @endforelse
    </div>
</x-app-layout>
