<div>
    <div class="mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-2">Pengaturan Sistem</h3>
        <p class="text-sm text-gray-600">Kelola pengaturan sistem, cache, dan pengaturan performa.</p>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="space-y-6">
        <!-- System Maintenance -->
        <div class="bg-white shadow rounded-lg p-6">
            <h4 class="text-lg font-medium text-gray-900 mb-4">Pemeliharaan Sistem</h4>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h5 class="text-sm font-medium text-gray-900">Mode Pemeliharaan</h5>
                        <p class="text-sm text-gray-500">Put the system in maintenance mode to prevent user access during updates.</p>
                    </div>
                    <button wire:click="toggleMaintenanceMode"
                            wire:confirm="Are you sure you want to {{ $maintenance_mode ? 'disable' : 'enable' }} maintenance mode?"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md {{ $maintenance_mode ? 'text-green-700 bg-green-100 hover:bg-green-200' : 'text-red-700 bg-red-100 hover:bg-red-200' }}">
                        {{ $maintenance_mode ? 'Disable Maintenance' : 'Enable Maintenance' }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Cache Management -->
        <div class="bg-white shadow rounded-lg p-6">
            <h4 class="text-lg font-medium text-gray-900 mb-4">Pengelolaan Cache</h4>
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h5 class="text-sm font-medium text-gray-900">Informasi Cache</h5>
                        <dl class="mt-2 text-sm text-gray-600">
                            <div class="flex justify-between">
                                <dt>Driver:</dt>
                                <dd>{{ $cacheInfo['cache_driver'] }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt>Size:</dt>
                                <dd>{{ $cacheInfo['cache_size'] }}</dd>
                            </div>
                        </dl>
                    </div>
                    <div class="space-y-2">
                        <button wire:click="clearCache"
                                wire:confirm="Are you sure you want to clear all caches?"
                                class="w-full inline-flex justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Hapus Semua Cache
                        </button>
                        <button wire:click="optimizeSystem"
                                wire:confirm="Are you sure you want to optimize the system?"
                                class="w-full inline-flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Optimize System
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Database Management -->
        <div class="bg-white shadow rounded-lg p-6">
            <h4 class="text-lg font-medium text-gray-900 mb-4">Pengelolaan Database</h4>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h5 class="text-sm font-medium text-gray-900">Migrasi Database</h5>
                        <p class="text-sm text-gray-500">Run pending database migrations to update the schema.</p>
                    </div>
                    <button wire:click="runMigrations"
                            wire:confirm="Are you sure you want to run database migrations? This may affect the database structure."
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700">
                        Jalankan Migrasi
                    </button>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h4 class="text-lg font-medium text-gray-900 mb-4">Informasi Sistem</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($systemInfo as $key => $value)
                    <div class="bg-gray-50 rounded-lg p-3">
                        <dt class="text-sm font-medium text-gray-500 capitalize">{{ str_replace('_', ' ', $key) }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $value }}</dd>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- System Status -->
        <div class="bg-white shadow rounded-lg p-6">
            <h4 class="text-lg font-medium text-gray-900 mb-4">Status Sistem</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold {{ $maintenance_mode ? 'text-red-600' : 'text-green-600' }}">
                        {{ $maintenance_mode ? 'DOWN' : 'UP' }}
                    </div>
                    <div class="text-sm text-gray-500">Status Sistem</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-blue-600">
                        {{ $systemInfo['php_version'] }}
                    </div>
                    <div class="text-sm text-gray-500">Versi PHP</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-purple-600">
                        {{ $systemInfo['laravel_version'] }}
                    </div>
                    <div class="text-sm text-gray-500">Versi Laravel</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold {{ $systemInfo['debug_mode'] === 'Enabled' ? 'text-yellow-600' : 'text-green-600' }}">
                        {{ $systemInfo['debug_mode'] === 'Enabled' ? 'DEBUG' : 'PROD' }}
                    </div>
                    <div class="text-sm text-gray-500">Mode Debug</div>
                </div>
            </div>
        </div>

        <!-- Warning Notice -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Perhatian Penting</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>Perubahan konfigurasi sistem dapat mempengaruhi performa dan ketersediaan aplikasi. Selalu uji perubahan dalam lingkungan pengembangan terlebih dahulu.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>