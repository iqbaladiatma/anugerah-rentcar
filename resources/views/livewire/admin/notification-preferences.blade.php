<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Pengaturan Notifikasi</h2>
            <p class="text-sm text-gray-600">Customize when and how you receive notifications</p>
        </div>
        <div class="flex items-center space-x-3">
            <button wire:click="resetToDefaults" 
                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Reset to Defaults
            </button>
            <button wire:click="savePreferences" 
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Simpan Pengaturan
            </button>
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

    <!-- Global Settings -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Pengaturan Global</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Waktu yang Disukai untuk Ringkasan Harian
                </label>
                <input type="time" 
                       wire:model="globalPreferredTime"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <p class="text-xs text-gray-500 mt-1">Waktu ketika ringkasan harian akan dikirim</p>
            </div>
        </div>
    </div>

    <!-- Notification Type Settings -->
    <div class="space-y-6">
        @foreach($notificationTypes as $type => $info)
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">{{ $info['label'] }}</h3>
                        <p class="text-sm text-gray-600">{{ $info['description'] }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Delivery Methods -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Metode Pengiriman</h4>
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       wire:model="preferences.{{ $type }}.email_enabled"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Email notifications</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       wire:model="preferences.{{ $type }}.sms_enabled"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">SMS notifications</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       wire:model="preferences.{{ $type }}.browser_enabled"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Browser notifications</span>
                            </label>
                        </div>
                    </div>

                    <!-- Timing -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Waktu</h4>
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       wire:model="preferences.{{ $type }}.instant_notifications"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Notifikasi instan</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       wire:model="preferences.{{ $type }}.daily_digest"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Ringkasan harian</span>
                            </label>
                        </div>
                    </div>

                    <!-- Priority Filter -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Level Prioritas</h4>
                        <div class="space-y-3">
                            @foreach(['high', 'medium', 'low'] as $priority)
                                <label class="flex items-center">
                                    <input type="checkbox" 
                                           @if(isset($preferences[$type]['priority_filter']) && in_array($priority, $preferences[$type]['priority_filter'])) checked @endif
                                           wire:click="togglePriority('{{ $type }}', '{{ $priority }}')"
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 capitalize">{{ $priority }}</span>
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                        {{ $priority === 'high' ? 'bg-red-100 text-red-800' : 
                                           ($priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ ucfirst($priority) }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Save Button (Bottom) -->
    <div class="flex justify-end">
        <button wire:click="savePreferences" 
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Simpan Pengaturan Semua
        </button>
    </div>
</div>

@script
<script>
    $wire.on('preferences-saved', () => {
        // Optional: Show success toast or animation
    });
</script>
@endscript