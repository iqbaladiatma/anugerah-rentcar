<div>
    <form wire:submit="save" class="space-y-6">
        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- License Plate -->
                <div>
                    <label for="license_plate" class="block text-sm font-medium text-gray-700 mb-1">
                        License Plate <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="license_plate"
                           wire:model="license_plate"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('license_plate') border-red-500 @enderror"
                           placeholder="B 1234 ABC">
                    @error('license_plate')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- STNK Number -->
                <div>
                    <label for="stnk_number" class="block text-sm font-medium text-gray-700 mb-1">
                        STNK Number <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="stnk_number"
                           wire:model="stnk_number"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('stnk_number') border-red-500 @enderror"
                           placeholder="Enter STNK number">
                    @error('stnk_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Brand -->
                <div>
                    <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">
                        Brand <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="brand"
                           wire:model="brand"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('brand') border-red-500 @enderror"
                           placeholder="Toyota, Honda, etc.">
                    @error('brand')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Model -->
                <div>
                    <label for="model" class="block text-sm font-medium text-gray-700 mb-1">
                        Model <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="model"
                           wire:model="model"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('model') border-red-500 @enderror"
                           placeholder="Avanza, Brio, etc.">
                    @error('model')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Year -->
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-1">
                        Year <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="year"
                           wire:model="year"
                           min="1900"
                           max="{{ date('Y') + 1 }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('year') border-red-500 @enderror"
                           placeholder="{{ date('Y') }}">
                    @error('year')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Color -->
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-1">
                        Color <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="color"
                           wire:model="color"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('color') border-red-500 @enderror"
                           placeholder="White, Black, Silver, etc.">
                    @error('color')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Documentation & Maintenance -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Documentation & Maintenance</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- STNK Expiry -->
                <div>
                    <label for="stnk_expiry" class="block text-sm font-medium text-gray-700 mb-1">
                        STNK Expiry Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           id="stnk_expiry"
                           wire:model="stnk_expiry"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('stnk_expiry') border-red-500 @enderror">
                    @error('stnk_expiry')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Oil Change -->
                <div>
                    <label for="last_oil_change" class="block text-sm font-medium text-gray-700 mb-1">
                        Last Oil Change Date
                    </label>
                    <input type="date" 
                           id="last_oil_change"
                           wire:model="last_oil_change"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('last_oil_change') border-red-500 @enderror">
                    @error('last_oil_change')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Oil Change Interval -->
                <div>
                    <label for="oil_change_interval_km" class="block text-sm font-medium text-gray-700 mb-1">
                        Oil Change Interval (KM)
                    </label>
                    <input type="number" 
                           id="oil_change_interval_km"
                           wire:model="oil_change_interval_km"
                           min="1000"
                           max="50000"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('oil_change_interval_km') border-red-500 @enderror"
                           placeholder="5000">
                    @error('oil_change_interval_km')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Odometer -->
                <div>
                    <label for="current_odometer" class="block text-sm font-medium text-gray-700 mb-1">
                        Current Odometer (KM) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="current_odometer"
                           wire:model="current_odometer"
                           min="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('current_odometer') border-red-500 @enderror"
                           placeholder="0">
                    @error('current_odometer')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Pricing Information -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Pricing Information</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Daily Rate -->
                <div>
                    <label for="daily_rate" class="block text-sm font-medium text-gray-700 mb-1">
                        Daily Rate (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="daily_rate"
                           wire:model="daily_rate"
                           min="0"
                           step="1000"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('daily_rate') border-red-500 @enderror"
                           placeholder="300000">
                    @error('daily_rate')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Weekly Rate -->
                <div>
                    <label for="weekly_rate" class="block text-sm font-medium text-gray-700 mb-1">
                        Weekly Rate (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="weekly_rate"
                           wire:model="weekly_rate"
                           min="0"
                           step="1000"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('weekly_rate') border-red-500 @enderror"
                           placeholder="1800000">
                    @error('weekly_rate')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Driver Fee Per Day -->
                <div>
                    <label for="driver_fee_per_day" class="block text-sm font-medium text-gray-700 mb-1">
                        Driver Fee/Day (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="driver_fee_per_day"
                           wire:model="driver_fee_per_day"
                           min="0"
                           step="1000"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('driver_fee_per_day') border-red-500 @enderror"
                           placeholder="100000">
                    @error('driver_fee_per_day')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Vehicle Status -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Vehicle Status</h3>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                    Status <span class="text-red-500">*</span>
                </label>
                <select id="status"
                        wire:model="status"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                    @foreach($statusOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Vehicle Photos -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Vehicle Photos</h3>
            <p class="text-sm text-gray-600 mb-6">Upload photos from three angles: front, side, and back view. Maximum file size: 2MB per photo.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Front Photo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Front View</label>
                    
                    @if($existing_photo_front && !$remove_photo_front && !$photo_front)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $existing_photo_front) }}" 
                                 alt="Current front photo" 
                                 class="w-full h-32 object-cover rounded-lg border border-gray-200">
                            <button type="button" 
                                    wire:click="removePhoto('front')"
                                    class="mt-2 text-sm text-red-600 hover:text-red-800">
                                Remove current photo
                            </button>
                        </div>
                    @elseif($remove_photo_front)
                        <div class="mb-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-sm text-red-600">Photo will be removed when saved.</p>
                            <button type="button" 
                                    wire:click="restorePhoto('front')"
                                    class="mt-1 text-sm text-blue-600 hover:text-blue-800">
                                Keep current photo
                            </button>
                        </div>
                    @endif

                    @if($photo_front)
                        <div class="mb-3">
                            <img src="{{ $photo_front->temporaryUrl() }}" 
                                 alt="New front photo preview" 
                                 class="w-full h-32 object-cover rounded-lg border border-gray-200">
                        </div>
                    @endif

                    <input type="file" 
                           wire:model="photo_front"
                           accept="image/jpeg,image/png,image/jpg"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('photo_front') border-red-500 @enderror">
                    @error('photo_front')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Side Photo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Side View</label>
                    
                    @if($existing_photo_side && !$remove_photo_side && !$photo_side)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $existing_photo_side) }}" 
                                 alt="Current side photo" 
                                 class="w-full h-32 object-cover rounded-lg border border-gray-200">
                            <button type="button" 
                                    wire:click="removePhoto('side')"
                                    class="mt-2 text-sm text-red-600 hover:text-red-800">
                                Remove current photo
                            </button>
                        </div>
                    @elseif($remove_photo_side)
                        <div class="mb-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-sm text-red-600">Photo will be removed when saved.</p>
                            <button type="button" 
                                    wire:click="restorePhoto('side')"
                                    class="mt-1 text-sm text-blue-600 hover:text-blue-800">
                                Keep current photo
                            </button>
                        </div>
                    @endif

                    @if($photo_side)
                        <div class="mb-3">
                            <img src="{{ $photo_side->temporaryUrl() }}" 
                                 alt="New side photo preview" 
                                 class="w-full h-32 object-cover rounded-lg border border-gray-200">
                        </div>
                    @endif

                    <input type="file" 
                           wire:model="photo_side"
                           accept="image/jpeg,image/png,image/jpg"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('photo_side') border-red-500 @enderror">
                    @error('photo_side')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Back Photo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Back View</label>
                    
                    @if($existing_photo_back && !$remove_photo_back && !$photo_back)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $existing_photo_back) }}" 
                                 alt="Current back photo" 
                                 class="w-full h-32 object-cover rounded-lg border border-gray-200">
                            <button type="button" 
                                    wire:click="removePhoto('back')"
                                    class="mt-2 text-sm text-red-600 hover:text-red-800">
                                Remove current photo
                            </button>
                        </div>
                    @elseif($remove_photo_back)
                        <div class="mb-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-sm text-red-600">Photo will be removed when saved.</p>
                            <button type="button" 
                                    wire:click="restorePhoto('back')"
                                    class="mt-1 text-sm text-blue-600 hover:text-blue-800">
                                Keep current photo
                            </button>
                        </div>
                    @endif

                    @if($photo_back)
                        <div class="mb-3">
                            <img src="{{ $photo_back->temporaryUrl() }}" 
                                 alt="New back photo preview" 
                                 class="w-full h-32 object-cover rounded-lg border border-gray-200">
                        </div>
                    @endif

                    <input type="file" 
                           wire:model="photo_back"
                           accept="image/jpeg,image/png,image/jpg"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('photo_back') border-red-500 @enderror">
                    @error('photo_back')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    <span class="text-red-500">*</span> Required fields
                </div>
                <div class="flex items-center space-x-3">
                    @if($isEditing && $this->vehicle && $this->vehicle->id)
                        <a href="{{ route('admin.vehicles.show', $this->vehicle) }}" 
                           class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                    @else
                        <a href="{{ route('admin.vehicles.index') }}" 
                           class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                    @endif
                    <button type="submit" 
                            class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
                            wire:loading.attr="disabled">
                        <span wire:loading.remove>
                            {{ $isEditing ? 'Update Vehicle' : 'Create Vehicle' }}
                        </span>
                        <span wire:loading>
                            {{ $isEditing ? 'Updating...' : 'Creating...' }}
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>