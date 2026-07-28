<x-app-layout>
    <x-slot:header>{{ __('Announcements') }}</x-slot>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Announcements') }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ __('Broadcast important updates to students and class groups.') }}</p>
        </div>
        <a href="{{ route('admin.announcements.create') }}" class="btn-primary text-sm">
            <svg class="w-4 h-4 me-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            {{ __('New Announcement') }}
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <x-ui.card>
        @if(isset($announcements) && count($announcements) > 0)
            <div class="p-6 space-y-4">
                @foreach($announcements as $ann)
                    <div class="p-4 rounded-xl border border-gray-100 bg-gray-50/50">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="font-bold text-gray-900 text-lg">{{ $ann->title }}</h3>
                            @if($ann->is_pinned)
                                <span class="text-xs bg-amber-100 text-amber-800 font-semibold px-2 py-0.5 rounded">{{ __('Pinned') }}</span>
                            @endif
                        </div>
                        <p class="text-gray-600 text-sm">{!! nl2br(e($ann->content)) !!}</p>
                        <p class="text-xs text-gray-400 mt-3">{{ $ann->published_at ? $ann->published_at->diffForHumans() : '' }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 text-center">
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ __('No announcements yet') }}</h3>
                    <p class="text-gray-500 text-sm max-w-sm mb-4">{{ __('Create your first announcement to keep students informed about important updates.') }}</p>
                    <a href="{{ route('admin.announcements.create') }}" class="btn-primary text-sm py-2 px-4">{{ __('New Announcement') }}</a>
                </div>
            </div>
        @endif
    </x-ui.card>
</x-app-layout>
