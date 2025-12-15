<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add Maintenance Record') }}
            </h2>
            <a href="{{ route('admin.maintenance.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <x-icons.arrow-left class="w-4 h-4 inline mr-1" />
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.maintenance.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Vehicle Selection -->
                            <div>
                                <x-input-label for="car_id" :value="__('Vehicle')" />
                                <select id="car_id" name="car_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Select Vehicle</option>
                                    @foreach($cars as $car)
                                        <option value="{{ $car->id }}" {{ old('car_id') == $car->id ? 'selected' : '' }}>
                                            {{ $car->license_plate }} - {{ $car->brand }} {{ $car->model }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('car_id')" class="mt-2" />
                            </div>

                            <!-- Maintenance Type -->
                            <div>
                                <x-input-label for="maintenance_type" :value="__('Maintenance Type')" />
                                <select id="maintenance_type" name="maintenance_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Select Type</option>
                                    <option value="routine" {{ old('maintenance_type') == 'routine' ? 'selected' : '' }}>Routine Maintenance</option>
                                    <option value="repair" {{ old('maintenance_type') == 'repair' ? 'selected' : '' }}>Repair</option>
                                    <option value="inspection" {{ old('maintenance_type') == 'inspection' ? 'selected' : '' }}>Inspection</option>
                                </select>
                                <x-input-error :messages="$errors->get('maintenance_type')" class="mt-2" />
                            </div>

                            <!-- Service Date -->
                            <div>
                                <x-input-label for="service_date" :value="__('Service Date')" />
                                <x-text-input id="service_date" name="service_date" type="date" class="mt-1 block w-full" 
                                              :value="old('service_date', date('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('service_date')" class="mt-2" />
                            </div>

                            <!-- Next Service Date -->
                            <div>
                                <x-input-label for="next_service_date" :value="__('Next Service Date (Optional)')" />
                                <x-text-input id="next_service_date" name="next_service_date" type="date" class="mt-1 block w-full" 
                                              :value="old('next_service_date')" />
                                <x-input-error :messages="$errors->get('next_service_date')" class="mt-2" />
                            </div>

                            <!-- Cost -->
                            <div>
                                <x-input-label for="cost" :value="__('Cost (IDR)')" />
                                <x-text-input id="cost" name="cost" type="number" step="0.01" min="0" class="mt-1 block w-full" 
                                              :value="old('cost')" required />
                                <x-input-error :messages="$errors->get('cost')" class="mt-2" />
                            </div>

                            <!-- Odometer Reading -->
                            <div>
                                <x-input-label for="odometer_at_service" :value="__('Odometer Reading (km)')" />
                                <x-text-input id="odometer_at_service" name="odometer_at_service" type="number" min="0" class="mt-1 block w-full" 
                                              :value="old('odometer_at_service')" required />
                                <x-input-error :messages="$errors->get('odometer_at_service')" class="mt-2" />
                            </div>

                            <!-- Service Provider -->
                            <div class="md:col-span-2">
                                <x-input-label for="service_provider" :value="__('Service Provider')" />
                                <x-text-input id="service_provider" name="service_provider" type="text" class="mt-1 block w-full" 
                                              :value="old('service_provider')" required />
                                <x-input-error :messages="$errors->get('service_provider')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <x-input-label for="description" :value="__('Description')" />
                                <textarea id="description" name="description" rows="4" 
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                          required>{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <!-- Receipt Photo -->
                            <div class="md:col-span-2">
                                <x-input-label for="receipt_photo" :value="__('Receipt Photo (Optional)')" />
                                <input id="receipt_photo" name="receipt_photo" type="file" accept="image/*" 
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                <p class="mt-1 text-sm text-gray-500">PNG, JPG up to 2MB</p>
                                <x-input-error :messages="$errors->get('receipt_photo')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.maintenance.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Save Maintenance Record') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>