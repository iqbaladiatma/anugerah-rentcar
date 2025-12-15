<div class="max-w-4xl mx-auto p-6">
    @if(!$showSummary)
        <!-- Checkout Form -->
        <div class="bg-white rounded-lg shadow-lg">
            <!-- Header -->
            <div class="bg-blue-600 text-white p-6 rounded-t-lg">
                <h2 class="text-2xl font-bold">Vehicle Check-Out</h2>
                <p class="text-blue-100 mt-2">{{ $booking->booking_number }} - {{ $booking->car->license_plate }}</p>
            </div>

            <!-- Booking Information -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold mb-4">Booking Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Customer</p>
                        <p class="font-medium">{{ $booking->customer->name }}</p>
                        <p class="text-sm text-gray-500">{{ $booking->customer->phone }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Vehicle</p>
                        <p class="font-medium">{{ $booking->car->brand }} {{ $booking->car->model }}</p>
                        <p class="text-sm text-gray-500">{{ $booking->car->license_plate }} - {{ $booking->car->color }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Rental Period</p>
                        <p class="font-medium">{{ $booking->start_date->format('d/m/Y H:i') }}</p>
                        <p class="text-sm text-gray-500">to {{ $booking->end_date->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Duration</p>
                        <p class="font-medium">{{ $booking->getDurationInDays() }} days</p>
                    </div>
                </div>
            </div>

            <!-- Validation Errors -->
            @if(!empty($validationErrors))
                <div class="p-6 border-b border-gray-200">
                    <div class="bg-red-50 border border-red-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                    @foreach($validationErrors as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form wire:submit.prevent="previewCheckout">
                <!-- Vehicle Condition -->
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Vehicle Condition</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Fuel Level -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fuel Level</label>
                            <select wire:model="inspectionData.fuel_level" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @foreach($fuelLevelOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Odometer Reading -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Odometer Reading (km)</label>
                            <input type="number" wire:model="inspectionData.odometer_reading" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   min="0" step="1">
                        </div>
                    </div>
                </div>

                <!-- Exterior Inspection -->
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Exterior Inspection</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($preparationData['inspection_checklist']['exterior'] as $key => $label)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-medium">{{ $label }}</h4>
                                    <div class="flex space-x-2">
                                        <button type="button" wire:click="addExteriorDamage('{{ $key }}')"
                                                class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded">
                                            Report Issue
                                        </button>
                                    </div>
                                </div>
                                
                                @if(!empty($inspectionData['exterior_condition'][$key]['damage']) || !empty($inspectionData['exterior_condition'][$key]['description']))
                                    <div class="mt-2 space-y-2">
                                        <select wire:model="inspectionData.exterior_condition.{{ $key }}.damage" 
                                                class="w-full text-sm border border-gray-300 rounded px-2 py-1">
                                            <option value="">No damage</option>
                                            @foreach($damageTypeOptions as $value => $damageLabel)
                                                <option value="{{ $value }}">{{ $damageLabel }}</option>
                                            @endforeach
                                        </select>
                                        <textarea wire:model="inspectionData.exterior_condition.{{ $key }}.description"
                                                  placeholder="Describe the condition or damage..."
                                                  class="w-full text-sm border border-gray-300 rounded px-2 py-1"
                                                  rows="2"></textarea>
                                        <button type="button" wire:click="removeExteriorDamage('{{ $key }}')"
                                                class="text-xs text-gray-500 hover:text-red-600">
                                            Clear
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Interior Inspection -->
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Interior Inspection</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($preparationData['inspection_checklist']['interior'] as $key => $label)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-medium">{{ $label }}</h4>
                                    <div class="flex space-x-2">
                                        <button type="button" wire:click="addInteriorDamage('{{ $key }}')"
                                                class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded">
                                            Report Issue
                                        </button>
                                    </div>
                                </div>
                                
                                @if(!empty($inspectionData['interior_condition'][$key]['damage']) || !empty($inspectionData['interior_condition'][$key]['description']))
                                    <div class="mt-2 space-y-2">
                                        <select wire:model="inspectionData.interior_condition.{{ $key }}.damage" 
                                                class="w-full text-sm border border-gray-300 rounded px-2 py-1">
                                            <option value="">No damage</option>
                                            @foreach($damageTypeOptions as $value => $damageLabel)
                                                <option value="{{ $value }}">{{ $damageLabel }}</option>
                                            @endforeach
                                        </select>
                                        <textarea wire:model="inspectionData.interior_condition.{{ $key }}.description"
                                                  placeholder="Describe the condition or damage..."
                                                  class="w-full text-sm border border-gray-300 rounded px-2 py-1"
                                                  rows="2"></textarea>
                                        <button type="button" wire:click="removeInteriorDamage('{{ $key }}')"
                                                class="text-xs text-gray-500 hover:text-red-600">
                                            Clear
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Photo Documentation -->
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Photo Documentation</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Photos</label>
                        <input type="file" wire:model="photos" multiple accept="image/*"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Maximum 2MB per image. Multiple images allowed.</p>
                    </div>

                    @if(!empty($photos))
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($photos as $index => $photo)
                                <div class="relative">
                                    <img src="{{ $photo->temporaryUrl() }}" alt="Inspection Photo" 
                                         class="w-full h-24 object-cover rounded border">
                                    <button type="button" wire:click="removePhoto({{ $index }})"
                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs">
                                        ×
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Digital Signatures -->
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Digital Signatures</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Inspector Signature -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Inspector Signature</label>
                            <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                                <canvas id="inspector-signature" width="300" height="150" 
                                        class="border border-gray-200 bg-white rounded cursor-crosshair w-full"></canvas>
                                <div class="mt-2 flex space-x-2">
                                    <button type="button" onclick="clearInspectorSignature()" 
                                            class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">
                                        Clear
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Signature -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Customer Signature</label>
                            <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                                <canvas id="customer-signature" width="300" height="150" 
                                        class="border border-gray-200 bg-white rounded cursor-crosshair w-full"></canvas>
                                <div class="mt-2 flex space-x-2">
                                    <button type="button" onclick="clearCustomerSignature()" 
                                            class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">
                                        Clear
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Additional Notes</h3>
                    <textarea wire:model="inspectionData.notes" 
                              placeholder="Any additional notes or observations..."
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                              rows="4"></textarea>
                </div>

                <!-- Actions -->
                <div class="p-6 bg-gray-50 rounded-b-lg">
                    <div class="flex justify-between">
                        <a href="{{ route('admin.bookings.show', $booking->id) }}" 
                           class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors">
                            Preview Check-Out
                        </button>
                    </div>
                </div>
            </form>
        </div>

    @else
        <!-- Summary Preview -->
        <div class="bg-white rounded-lg shadow-lg">
            <!-- Header -->
            <div class="bg-green-600 text-white p-6 rounded-t-lg">
                <h2 class="text-2xl font-bold">Check-Out Summary</h2>
                <p class="text-green-100 mt-2">Please review before confirming</p>
            </div>

            <!-- Summary Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Booking Details -->
                    <div>
                        <h3 class="text-lg font-semibold mb-3">Booking Details</h3>
                        <dl class="space-y-2">
                            @foreach($summary['booking_details'] as $key => $value)
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-600">{{ ucwords(str_replace('_', ' ', $key)) }}:</dt>
                                    <dd class="text-sm font-medium">{{ $value }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>

                    <!-- Vehicle Condition -->
                    <div>
                        <h3 class="text-lg font-semibold mb-3">Vehicle Condition</h3>
                        <dl class="space-y-2">
                            @foreach($summary['vehicle_condition'] as $key => $value)
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-600">{{ ucwords(str_replace('_', ' ', $key)) }}:</dt>
                                    <dd class="text-sm font-medium">{{ $value }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                </div>

                <!-- Signatures Status -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-3">Signatures</h3>
                    <div class="flex space-x-6">
                        <div class="flex items-center">
                            <span class="w-3 h-3 rounded-full {{ $summary['signatures']['inspector_signed'] ? 'bg-green-500' : 'bg-red-500' }} mr-2"></span>
                            <span class="text-sm">Inspector Signature</span>
                        </div>
                        <div class="flex items-center">
                            <span class="w-3 h-3 rounded-full {{ $summary['signatures']['customer_signed'] ? 'bg-green-500' : 'bg-red-500' }} mr-2"></span>
                            <span class="text-sm">Customer Signature</span>
                        </div>
                    </div>
                </div>

                <!-- Ready Status -->
                @if($summary['ready_for_checkout'])
                    <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-green-800 font-medium">Ready for check-out</span>
                        </div>
                    </div>
                @else
                    <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-red-800 font-medium">Please complete all required fields</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="p-6 bg-gray-50 rounded-b-lg">
                <div class="flex justify-between">
                    <button wire:click="backToForm" 
                            class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition-colors">
                        Back to Form
                    </button>
                    @if($summary['ready_for_checkout'])
                        <button wire:click="processCheckout" 
                                class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition-colors">
                            Confirm Check-Out
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    // Digital signature functionality
    let inspectorCanvas, customerCanvas;
    let inspectorCtx, customerCtx;
    let isDrawingInspector = false, isDrawingCustomer = false;

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize inspector signature canvas
        inspectorCanvas = document.getElementById('inspector-signature');
        inspectorCtx = inspectorCanvas.getContext('2d');
        
        // Initialize customer signature canvas
        customerCanvas = document.getElementById('customer-signature');
        customerCtx = customerCanvas.getContext('2d');

        // Inspector signature events
        inspectorCanvas.addEventListener('mousedown', startDrawingInspector);
        inspectorCanvas.addEventListener('mousemove', drawInspector);
        inspectorCanvas.addEventListener('mouseup', stopDrawingInspector);
        inspectorCanvas.addEventListener('touchstart', startDrawingInspector);
        inspectorCanvas.addEventListener('touchmove', drawInspector);
        inspectorCanvas.addEventListener('touchend', stopDrawingInspector);

        // Customer signature events
        customerCanvas.addEventListener('mousedown', startDrawingCustomer);
        customerCanvas.addEventListener('mousemove', drawCustomer);
        customerCanvas.addEventListener('mouseup', stopDrawingCustomer);
        customerCanvas.addEventListener('touchstart', startDrawingCustomer);
        customerCanvas.addEventListener('touchmove', drawCustomer);
        customerCanvas.addEventListener('touchend', stopDrawingCustomer);
    });

    function startDrawingInspector(e) {
        isDrawingInspector = true;
        draw(e, inspectorCanvas, inspectorCtx);
    }

    function drawInspector(e) {
        if (!isDrawingInspector) return;
        draw(e, inspectorCanvas, inspectorCtx);
        updateInspectorSignature();
    }

    function stopDrawingInspector() {
        isDrawingInspector = false;
        updateInspectorSignature();
    }

    function startDrawingCustomer(e) {
        isDrawingCustomer = true;
        draw(e, customerCanvas, customerCtx);
    }

    function drawCustomer(e) {
        if (!isDrawingCustomer) return;
        draw(e, customerCanvas, customerCtx);
        updateCustomerSignature();
    }

    function stopDrawingCustomer() {
        isDrawingCustomer = false;
        updateCustomerSignature();
    }

    function draw(e, canvas, ctx) {
        const rect = canvas.getBoundingClientRect();
        const x = (e.clientX || e.touches[0].clientX) - rect.left;
        const y = (e.clientY || e.touches[0].clientY) - rect.top;

        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#000';

        ctx.lineTo(x, y);
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(x, y);
    }

    function clearInspectorSignature() {
        inspectorCtx.clearRect(0, 0, inspectorCanvas.width, inspectorCanvas.height);
        @this.set('inspectorSignature', null);
    }

    function clearCustomerSignature() {
        customerCtx.clearRect(0, 0, customerCanvas.width, customerCanvas.height);
        @this.set('customerSignature', null);
    }

    function updateInspectorSignature() {
        const dataURL = inspectorCanvas.toDataURL();
        @this.set('inspectorSignature', dataURL);
    }

    function updateCustomerSignature() {
        const dataURL = customerCanvas.toDataURL();
        @this.set('customerSignature', dataURL);
    }
</script>
@endpush