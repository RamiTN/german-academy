<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" @click.away="open = false" class="relative p-2 text-gray-500 hover:text-gray-700 transition-colors rounded-full hover:bg-gray-100 focus:outline-none">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        
        <!-- Unread Badge -->
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute top-1.5 end-1.5 flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
            </span>
        @endif
    </button>

    <!-- Dropdown -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute end-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50"
         style="display: none;">
        
        <div class="px-4 py-3 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <span class="text-xs font-medium text-accent hover:text-accent-hover cursor-pointer">Mark all read</span>
            @endif
        </div>
        
        <div class="max-h-96 overflow-y-auto">
            @forelse(auth()->user()->unreadNotifications as $notification)
                <div class="px-4 py-3 border-b border-gray-50 hover:bg-gray-50 transition-colors flex gap-3 cursor-pointer">
                    <div class="mt-0.5">
                        <div class="w-2 h-2 rounded-full bg-accent"></div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-800">{{ $notification->data['message'] ?? 'New notification' }}</p>
                        <span class="text-xs text-gray-500 mt-1 block">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @empty
                <div class="px-4 py-8 text-center">
                    <svg class="mx-auto h-8 w-8 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <p class="text-sm text-gray-500">You're all caught up!</p>
                </div>
            @endforelse
        </div>
        
        <div class="px-4 py-2 border-t border-gray-100 text-center bg-gray-50">
            <a href="#" class="text-xs font-medium text-gray-500 hover:text-gray-900">View all notifications</a>
        </div>
    </div>
</div>
