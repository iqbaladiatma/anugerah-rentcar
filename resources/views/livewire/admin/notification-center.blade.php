<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Pusat Notifikasi</h2>
            <p class="text-sm text-gray-600">Kelola dan lihat notifikasi sistem</p>
        </div>
        <div class="flex items-center space-x-3">
            <button wire:click="refreshNotifications" 
                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <x-icons.arrow-path class="w-4 h-4 mr-2" />
                Refresh
            </button>
            @if($unreadCount > 0)
                <button wire:click="markAllAsRead" 
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Mark All Read ({{ $unreadCount }})
                </button>
            @endif
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg p-4">
        <div class="flex flex-wrap items-center gap-4">
            <!-- Unread Filter -->
            <label class="flex items-center">
                <input type="checkbox" wire:model.live="showUnreadOnly" 
                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <span class="ml-2 text-sm text-gray-700">Tampilkan yang belum dibaca</span>
            </label>

            <!-- Type Filter -->
            <div class="flex items-center space-x-2">
                <label class="text-sm font-medium text-gray-700">Jenis:</label>
                <select wire:model.live="selectedType" 
                        class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm">
                    @foreach($notificationTypes as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Priority Filter -->
            <div class="flex items-center space-x-2">
                <label class="text-sm font-medium text-gray-700">Prioritas:</label>
                <select wire:model.live="selectedPriority" 
                        class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm">
                    @foreach($priorityOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Clear Filters -->
            @if($showUnreadOnly || $selectedType || $selectedPriority)
                <button wire:click="clearFilters" 
                        class="text-sm text-blue-600 hover:text-blue-800">
                    Clear filters
                </button>
            @endif
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="bg-green-50 border border-green-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <x-icons.check-circle class="h-5 w-5 text-green-400" />
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">
                        {{ session('message') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Notifications List -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        @if($notifications->count() > 0)
            <ul class="divide-y divide-gray-200">
                @foreach($notifications as $notification)
                    <li class="relative {{ $notification->isUnread() ? 'bg-blue-50' : 'bg-white' }}">
                        <div class="px-4 py-4 flex items-start space-x-4">
                            <!-- Icon -->
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $notification->priority_color }}">
                                    <x-dynamic-component :component="'icons.' . $notification->icon_class" class="w-5 h-5" />
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $notification->title }}
                                            @if($notification->isUnread())
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 ml-2">
                                                    Baru
                                                </span>
                                            @endif
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ $notification->message }}
                                        </p>
                                        @if($notification->details)
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $notification->details }}
                                            </p>
                                        @endif
                                        <div class="flex items-center mt-2 space-x-4">
                                            <span class="text-xs text-gray-500">
                                                {{ $notification->time_ago }}
                                            </span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                {{ $notification->priority === 'high' ? 'bg-red-100 text-red-800' : 
                                                   ($notification->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ ucfirst($notification->priority) }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-center space-x-2">
                                        @if($notification->action_url)
                                            <a href="{{ $notification->action_url }}" 
                                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                Lihat
                                            </a>
                                        @endif
                                        @if($notification->isUnread())
                                            <button wire:click="markAsRead({{ $notification->id }})" 
                                                    class="text-gray-400 hover:text-gray-600">
                                                <x-icons.check class="w-4 h-4" />
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <!-- Pagination -->
            <div class="bg-white px-4 py-3 border-t border-gray-200">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <x-icons.bell class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada notifikasi</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if($showUnreadOnly || $selectedType || $selectedPriority)
                        Tidak ada notifikasi yang cocok dengan filter yang Anda pilih.
                    @else
                        Anda sudah terpangkat! Tidak ada notifikasi untuk ditampilkan.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>

@script
<script>
    // Auto-refresh notifications every 30 seconds
    setInterval(() => {
        $wire.dispatch('refresh-notifications');
    }, 30000);

    // Listen for notification events
    $wire.on('notification-read', () => {
        // Optional: Show toast or update UI
    });

    $wire.on('notifications-marked-read', (event) => {
        // Optional: Show toast with count
    });

    $wire.on('notifications-refreshed', () => {
        // Optional: Show refresh indicator
    });
</script>
@endscript