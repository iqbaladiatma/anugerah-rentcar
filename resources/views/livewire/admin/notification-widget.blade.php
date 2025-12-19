<div class="relative" x-data="{ open: false }">
    <!-- Notification Bell -->
    <button @click="open = !open" 
            class="relative p-2 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded-full">
        <span class="sr-only">Lihat Notifikasi</span>
        <x-icons.bell class="h-6 w-6" />
        
        <!-- Notification Badge -->
        @if($this->unreadCount > 0)
            <span class="absolute -top-1 -right-1 h-5 w-5 rounded-full bg-red-500 text-xs text-white flex items-center justify-center font-medium">
                {{ $this->unreadCount > 9 ? '9+' : $this->unreadCount }}
            </span>
        @endif
    </button>

    <!-- Dropdown Panel -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         @click.away="open = false"
         style="display: none;"
         class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
        
        <!-- Header -->
        <div class="px-4 py-3 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-900">Notifikasi</h3>
                @if($this->unreadCount > 0)
                    <button wire:click="markAllAsRead" 
                            class="text-xs text-blue-600 hover:text-blue-800">
                        Tandai Semua Sudah Dibaca
                    </button>
                @endif
            </div>
        </div>

        <!-- Notifications List -->
        <div class="max-h-96 overflow-y-auto">
            @if($this->recentNotifications->count() > 0)
                @foreach($this->recentNotifications as $notification)
                    <div class="px-4 py-3 hover:bg-gray-50 {{ $notification->isUnread() ? 'bg-blue-50' : '' }}">
                        <div class="flex items-start space-x-3">
                            <!-- Icon -->
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $notification->priority_color }}">
                                    <x-dynamic-component :component="'icons.' . $notification->icon_class" class="w-4 h-4" />
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $notification->title }}
                                </p>
                                <p class="text-xs text-gray-600 mt-1 line-clamp-2">
                                    {{ $notification->message }}
                                </p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-xs text-gray-500">
                                        {{ $notification->time_ago }}
                                    </span>
                                    <div class="flex items-center space-x-2">
                                        @if($notification->action_url)
                                            <a href="{{ $notification->action_url }}" 
                                               class="text-xs text-blue-600 hover:text-blue-800">
                                                Lihat
                                            </a>
                                        @endif
                                        @if($notification->isUnread())
                                            <button wire:click="markAsRead({{ $notification->id }})" 
                                                    class="text-xs text-gray-400 hover:text-gray-600">
                                                <x-icons.check class="w-3 h-3" />
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="px-4 py-8 text-center">
                    <x-icons.bell class="mx-auto h-8 w-8 text-gray-400" />
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada notifikasi</h3>
                    <p class="mt-1 text-sm text-gray-500">Anda sudah terkumpul!</p>
                </div>
            @endif
        </div>

        <!-- Footer -->
        @if($this->recentNotifications->count() > 0)
            <div class="px-4 py-3 border-t border-gray-200">
                <a href="{{ route('admin.notifications.index') }}" 
                   class="block text-center text-sm text-blue-600 hover:text-blue-800">
                    Lihat Semua Notifikasi
                </a>
            </div>
        @endif
    </div>
</div>

@script
<script>
    // Auto-refresh notifications every 30 seconds
    setInterval(() => {
        $wire.$refresh();
    }, 30000);

    // Listen for notification events
    $wire.on('notification-read', () => {
        // Optional: Show toast or update UI
    });

    $wire.on('notifications-marked-read', () => {
        // Optional: Show success message
    });
</script>
@endscript