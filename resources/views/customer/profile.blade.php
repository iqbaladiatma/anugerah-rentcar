<x-public-layout>
    <div class="bg-white">
        <!-- Header -->
        <div class="bg-gray-50 border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
                <p class="mt-2 text-gray-600">Manage your account information and preferences</p>
            </div>
        </div>

        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if(session('success'))
                <div class="mb-6 rounded-md bg-green-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg">
                <!-- Profile Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-xl font-semibold text-blue-600">
                                {{ strtoupper(substr($customer->name, 0, 2)) }}
                            </span>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900">{{ $customer->name }}</h2>
                            <p class="text-sm text-gray-500">{{ $customer->email }}</p>
                            @if($customer->is_member)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mt-1">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Premium Member
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Profile Form -->
                <form method="POST" action="{{ route('customer.profile.update') }}" class="p-6">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', $customer->phone) }}" required
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea name="address" id="address" rows="3" required
                                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('address', $customer->address) }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- NIK (Read-only) -->
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700">NIK (Identity Number)</label>
                            <input type="text" name="nik" id="nik" value="{{ $customer->nik }}" readonly
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50 text-gray-500">
                            <p class="mt-1 text-sm text-gray-500">NIK cannot be changed. Contact support if you need to update this information.</p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6 flex justify-end">
                        <button type="submit" 
                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>

            <!-- Account Information -->
            <div class="mt-8 bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Account Information</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $customer->created_at->format('M d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total Bookings</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $customer->bookings()->count() }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Account Status</dt>
                            <dd class="mt-1">
                                @if($customer->is_blacklisted)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Restricted
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Member Discount</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($customer->is_member)
                                    {{ $customer->getMemberDiscountPercentage() }}%
                                @else
                                    Not a member
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Document Upload Section -->
            <div class="mt-8 bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Identity Documents</h3>
                    <p class="mt-1 text-sm text-gray-500">Upload your KTP and driving license for verification</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- KTP Photo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">KTP (Identity Card)</label>
                            @if($customer->ktp_photo)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $customer->ktp_photo) }}" 
                                         alt="KTP" class="h-32 w-full object-cover rounded-md border">
                                </div>
                                <p class="text-sm text-green-600 mb-2">✓ KTP uploaded</p>
                            @else
                                <div class="mb-3 h-32 border-2 border-dashed border-gray-300 rounded-md flex items-center justify-center">
                                    <div class="text-center">
                                        <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                        </svg>
                                        <p class="text-sm text-gray-500">No KTP uploaded</p>
                                    </div>
                                </div>
                            @endif
                            <button class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                                {{ $customer->ktp_photo ? 'Update KTP' : 'Upload KTP' }}
                            </button>
                        </div>

                        <!-- SIM Photo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">SIM (Driving License)</label>
                            @if($customer->sim_photo)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $customer->sim_photo) }}" 
                                         alt="SIM" class="h-32 w-full object-cover rounded-md border">
                                </div>
                                <p class="text-sm text-green-600 mb-2">✓ SIM uploaded</p>
                            @else
                                <div class="mb-3 h-32 border-2 border-dashed border-gray-300 rounded-md flex items-center justify-center">
                                    <div class="text-center">
                                        <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                        </svg>
                                        <p class="text-sm text-gray-500">No SIM uploaded</p>
                                    </div>
                                </div>
                            @endif
                            <button class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                                {{ $customer->sim_photo ? 'Update SIM' : 'Upload SIM' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>