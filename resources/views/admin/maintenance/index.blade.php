<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Maintenance Management') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.maintenance.create') }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <x-icons.plus class="w-4 h-4 inline mr-1" />
                    Add Maintenance
                </a>
                <button onclick="window.location.href='{{ route('admin.maintenance.export') }}'" 
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Export Data
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.currency-dollar class="h-8 w-8 text-green-500" />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Cost</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    Rp {{ number_format($totalCost, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.calendar class="h-8 w-8 text-blue-500" />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">This Month</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    Rp {{ number_format($thisMonthCost, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.wrench class="h-8 w-8 text-red-500" />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Overdue</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $overdueMaintenance }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.clock class="h-8 w-8 text-yellow-500" />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Due Soon</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $dueSoonMaintenance }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button onclick="showTab('maintenance-list')" 
                                class="tab-button active border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                            Maintenance Records
                        </button>
                        <button onclick="showTab('maintenance-scheduler')" 
                                class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                            Schedule & Reminders
                        </button>
                        <button onclick="showTab('maintenance-analytics')" 
                                class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                            Analytics & Reports
                        </button>
                    </nav>
                </div>

                <!-- Tab Contents -->
                <div id="maintenance-list" class="tab-content">
                    <livewire:admin.maintenance-list />
                </div>

                <div id="maintenance-scheduler" class="tab-content hidden">
                    <livewire:admin.maintenance-scheduler />
                </div>

                <div id="maintenance-analytics" class="tab-content hidden">
                    <livewire:admin.maintenance-analytics />
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active class from all tab buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'border-blue-500', 'text-blue-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected tab content
            document.getElementById(tabName).classList.remove('hidden');
            
            // Add active class to clicked button
            event.target.classList.remove('border-transparent', 'text-gray-500');
            event.target.classList.add('active', 'border-blue-500', 'text-blue-600');
        }
    </script>

    <style>
        .tab-button.active {
            border-color: #3B82F6;
            color: #2563EB;
        }
    </style>
</x-admin-layout>