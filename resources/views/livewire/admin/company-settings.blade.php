<div>
    <div class="mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-2">Company Information</h3>
        <p class="text-sm text-gray-600">Update your company details and branding information.</p>
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

    <form wire:submit.prevent="save" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Company Name -->
            <div>
                <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                <input type="text" 
                       id="company_name" 
                       wire:model="company_name"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('company_name') border-red-300 @enderror">
                @error('company_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Company Phone -->
            <div>
                <label for="company_phone" class="block text-sm font-medium text-gray-700">Company Phone</label>
                <input type="text" 
                       id="company_phone" 
                       wire:model="company_phone"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('company_phone') border-red-300 @enderror">
                @error('company_phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Company Address -->
        <div>
            <label for="company_address" class="block text-sm font-medium text-gray-700">Company Address</label>
            <textarea id="company_address" 
                      wire:model="company_address"
                      rows="3"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('company_address') border-red-300 @enderror"></textarea>
            @error('company_address')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Company Logo -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Company Logo</label>
            <div class="mt-1 flex items-center space-x-4">
                <!-- Current Logo Display -->
                @if($current_logo || $logo_preview)
                    <div class="flex-shrink-0">
                        <img class="h-20 w-20 object-contain border border-gray-300 rounded-lg" 
                             src="{{ $logo_preview ?: asset('storage/' . $current_logo) }}" 
                             alt="Company Logo">
                    </div>
                @else
                    <div class="flex-shrink-0">
                        <div class="h-20 w-20 bg-gray-100 border border-gray-300 rounded-lg flex items-center justify-center">
                            <x-icons.office-building class="h-8 w-8 text-gray-400" />
                        </div>
                    </div>
                @endif

                <div class="flex-1">
                    <input type="file" 
                           wire:model="company_logo"
                           accept="image/*"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    
                    @if($current_logo)
                        <button type="button" 
                                wire:click="removeLogo"
                                class="mt-2 text-sm text-red-600 hover:text-red-800">
                            Remove current logo
                        </button>
                    @endif
                </div>
            </div>
            @error('company_logo')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-sm text-gray-500">Upload a logo image (JPEG, PNG, JPG). Maximum file size: 2MB.</p>
        </div>

        <!-- Loading indicator -->
        <div wire:loading wire:target="company_logo" class="text-sm text-gray-500">
            Uploading logo...
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" 
                    wire:loading.attr="disabled"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
                <span wire:loading.remove wire:target="save">Save Changes</span>
                <span wire:loading wire:target="save">Saving...</span>
            </button>
        </div>
    </form>
</div>