<div>
    <!-- Search Form -->
    <div class="bg-white shadow sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                Advanced Customer Search
            </h3>
            
            <!-- Basic Search Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" 
                           wire:model.live.debounce.300ms="name" 
                           id="name"
                           placeholder="Customer name..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" 
                           wire:model.live.debounce.300ms="phone" 
                           id="phone"
                           placeholder="Phone number..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" 
                           wire:model.live.debounce.300ms="email" 
                           id="email"
                           placeholder="Email address..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                    <input type="text" 
                           wire:model.live.debounce.300ms="nik" 
                           id="nik"
                           placeholder="NIK number..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            
            <!-- Status Filters -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <div>
                    <label for="is_member" class="block text-sm font-medium text-gray-700 mb-1">Member Status</label>
                    <select wire:model.live="is_member" 
                            id="is_member"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($memberOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="is_blacklisted" class="block text-sm font-medium text-gray-700 mb-1">Account Status</label>
                    <select wire:model.live="is_blacklisted" 
                            id="is_blacklisted"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($blacklistOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="loyalty_tier" class="block text-sm font-medium text-gray-700 mb-1">Loyalty Tier</label>
                    <select wire:model.live="loyalty_tier" 
                            id="loyalty_tier"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($loyaltyTierOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="risk_level" class="block text-sm font-medium text-gray-700 mb-1">Risk Level</label>
                    <select wire:model.live="risk_level" 
                            id="risk_level"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($riskLevelOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <!-- Advanced Filters Toggle -->
            <div class="mb-4">
                <button wire:click="toggleAdvancedFilters" 
                        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    {{ $showAdvancedFilters ? 'Hide' : 'Show' }} Advanced Filters
                </button>
            </div>
            
            <!-- Advanced Filters -->
            @if($showAdvancedFilters)
                <div class="border-t pt-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="min_bookings" class="block text-sm font-medium text-gray-700 mb-1">Min Bookings</label>
                            <input type="number" 
                                   wire:model.live.debounce.500ms="min_bookings" 
                                   id="min_bookings"
                                   min="0"
                                   placeholder="Minimum bookings..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="max_bookings" class="block text-sm font-medium text-gray-700 mb-1">Max Bookings</label>
                            <input type="number" 
                                   wire:model.live.debounce.500ms="max_bookings" 
                                   id="max_bookings"
                                   min="0"
                                   placeholder="Maximum bookings..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="min_revenue" class="block text-sm font-medium text-gray-700 mb-1">Min Revenue (IDR)</label>
                            <input type="number" 
                                   wire:model.live.debounce.500ms="min_revenue" 
                                   id="min_revenue"
                                   min="0"
                                   step="100000"
                                   placeholder="Minimum revenue..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="max_revenue" class="block text-sm font-medium text-gray-700 mb-1">Max Revenue (IDR)</label>
                            <input type="number" 
                                   wire:model.live.debounce.500ms="max_revenue" 
                                   id="max_revenue"
                                   min="0"
                                   step="100000"
                                   placeholder="Maximum revenue..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   wire:model.live="has_overdue_bookings" 
                                   id="has_overdue_bookings"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="has_overdue_bookings" class="ml-2 block text-sm text-gray-900">
                                Has overdue bookings
                            </label>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Action Buttons -->
            <div class="flex justify-between items-center">
                <button wire:click="clearFilters" 
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Clear All Filters
                </button>
                
                @if($hasSearched && $searchResults)
                    <div class="text-sm text-gray-600">
                        Found {{ $searchResults->total() }} customer(s)
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div wire:loading class="mb-4">
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
            Searching customers...
        </div>
    </div>

    <!-- Search Results -->
    @if($hasSearched)
        @if($searchResults && $searchResults->count() > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        Search Results ({{ $searchResults->total() }} found)
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Customer
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Contact
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status & Tier
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Statistics
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Risk Assessment
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($searchResults as $customer)
                                    @php 
                                        $stats = $customerStats[$customer->id] ?? null;
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                        <x-icons.user class="h-6 w-6 text-gray-600" />
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $customer->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        NIK: {{ $customer->nik }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $customer->phone }}</div>
                                            @if($customer->email)
                                                <div class="text-sm text-gray-500">{{ $customer->email }}</div>
                                            @endif
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col space-y-1">
                                                @if($customer->is_member)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <x-icons.star class="w-3 h-3 mr-1" />
                                                        Member
                                                    </span>
                                                @endif
                                                
                                                @if($customer->is_blacklisted)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        <x-icons.ban class="w-3 h-3 mr-1" />
                                                        Blacklisted
                                                    </span>
                                                @endif
                                                
                                                @if($stats)
                                                    @php $loyaltyTier = $stats['loyalty_tier'] @endphp
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                        {{ $loyaltyTier === 'platinum' ? 'bg-purple-100 text-purple-800' : 
                                                           ($loyaltyTier === 'gold' ? 'bg-yellow-100 text-yellow-800' : 
                                                           ($loyaltyTier === 'silver' ? 'bg-gray-100 text-gray-800' : 'bg-orange-100 text-orange-800')) }}">
                                                        {{ ucfirst($loyaltyTier) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($stats)
                                                @php $statistics = $stats['statistics'] @endphp
                                                <div class="text-sm text-gray-900">
                                                    <div>Bookings: {{ $statistics['total_bookings'] }}</div>
                                                    <div>Revenue: IDR {{ number_format($statistics['total_revenue'], 0, ',', '.') }}</div>
                                                    <div class="text-gray-500">
                                                        Completion: {{ number_format($statistics['completion_rate'], 1) }}%
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($stats)
                                                @php $risk = $stats['risk_assessment'] @endphp
                                                <div class="flex flex-col space-y-1">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                        {{ $risk['risk_level'] === 'high' ? 'bg-red-100 text-red-800' : 
                                                           ($risk['risk_level'] === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                                        {{ ucfirst($risk['risk_level']) }} Risk
                                                    </span>
                                                    @if($risk['overdue_bookings'] > 0)
                                                        <span class="text-xs text-red-600">
                                                            {{ $risk['overdue_bookings'] }} overdue
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-2">
                                                <a href="{{ route('admin.customers.show', $customer) }}" 
                                                   class="text-blue-600 hover:text-blue-900">
                                                    View
                                                </a>
                                                <a href="{{ route('admin.customers.edit', $customer) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900">
                                                    Edit
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($searchResults->hasPages())
                        <div class="mt-4">
                            {{ $searchResults->links() }}
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6 text-center">
                    <x-icons.users class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No customers found</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        No customers match your search criteria. Try adjusting your filters.
                    </p>
                </div>
            </div>
        @endif
    @else
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6 text-center">
                <x-icons.users class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-2 text-sm font-medium text-gray-900">Customer Search</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Use the search form above to find customers by various criteria.
                </p>
            </div>
        </div>
    @endif
</div>