<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\CarInspection;
use App\Services\CheckoutService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class VehicleCheckoutForm extends Component
{
    use WithFileUploads;

    public Booking $booking;
    public array $inspectionData = [];
    public array $photos = [];
    public $inspectorSignature;
    public $customerSignature;
    public bool $showSummary = false;
    public array $summary = [];
    public array $validationErrors = [];

    protected CheckoutService $checkoutService;

    public function boot(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    public function mount(Booking $booking)
    {
        $this->booking = $booking;
        $this->initializeInspectionData();
    }

    protected function initializeInspectionData()
    {
        $preparationData = $this->checkoutService->getCheckoutPreparationData($this->booking);
        
        $this->inspectionData = [
            'fuel_level' => CarInspection::FUEL_FULL,
            'odometer_reading' => $preparationData['vehicle_current_condition']['odometer_reading'],
            'exterior_condition' => [],
            'interior_condition' => [],
            'notes' => '',
        ];

        // Initialize condition arrays for each checklist item
        $checklist = $this->checkoutService->getInspectionChecklist();
        foreach ($checklist['exterior'] as $key => $label) {
            $this->inspectionData['exterior_condition'][$key] = [
                'area' => $label,
                'damage' => '',
                'description' => ''
            ];
        }
        
        foreach ($checklist['interior'] as $key => $label) {
            $this->inspectionData['interior_condition'][$key] = [
                'area' => $label,
                'damage' => '',
                'description' => ''
            ];
        }
    }

    public function updatedPhotos()
    {
        $this->validate([
            'photos.*' => 'image|max:2048', // 2MB Max
        ]);
    }

    public function addExteriorDamage($area)
    {
        if (!isset($this->inspectionData['exterior_condition'][$area])) {
            $this->inspectionData['exterior_condition'][$area] = [
                'area' => $area,
                'damage' => '',
                'description' => ''
            ];
        }
    }

    public function removeExteriorDamage($area)
    {
        if (isset($this->inspectionData['exterior_condition'][$area])) {
            $this->inspectionData['exterior_condition'][$area]['damage'] = '';
            $this->inspectionData['exterior_condition'][$area]['description'] = '';
        }
    }

    public function addInteriorDamage($area)
    {
        if (!isset($this->inspectionData['interior_condition'][$area])) {
            $this->inspectionData['interior_condition'][$area] = [
                'area' => $area,
                'damage' => '',
                'description' => ''
            ];
        }
    }

    public function removeInteriorDamage($area)
    {
        if (isset($this->inspectionData['interior_condition'][$area])) {
            $this->inspectionData['interior_condition'][$area]['damage'] = '';
            $this->inspectionData['interior_condition'][$area]['description'] = '';
        }
    }

    public function removePhoto($index)
    {
        if (isset($this->photos[$index])) {
            unset($this->photos[$index]);
            $this->photos = array_values($this->photos); // Re-index array
        }
    }

    public function previewCheckout()
    {
        $this->validateInspectionData();
        
        if (empty($this->validationErrors)) {
            $inspectionDataWithFiles = $this->prepareInspectionDataForPreview();
            $this->summary = $this->checkoutService->getCheckoutSummary($this->booking, $inspectionDataWithFiles);
            $this->showSummary = true;
        }
    }

    public function processCheckout()
    {
        $this->validateInspectionData();
        
        if (!empty($this->validationErrors)) {
            return;
        }

        try {
            $inspectionDataWithFiles = $this->prepareInspectionDataForSubmission();
            $result = $this->checkoutService->processCheckout($this->booking, $inspectionDataWithFiles);
            
            session()->flash('success', 'Vehicle checkout completed successfully!');
            
            // Redirect to booking details or checkout confirmation page
            return redirect()->route('admin.bookings.show', $this->booking->id);
            
        } catch (\Exception $e) {
            session()->flash('error', 'Checkout failed: ' . $e->getMessage());
        }
    }

    public function backToForm()
    {
        $this->showSummary = false;
    }

    protected function validateInspectionData()
    {
        $validation = $this->checkoutService->validateInspectionData($this->inspectionData);
        $this->validationErrors = $validation['errors'];

        // Additional validation for signatures
        if (!$this->inspectorSignature) {
            $this->validationErrors[] = 'Inspector signature is required';
        }

        if (!$this->customerSignature) {
            $this->validationErrors[] = 'Customer signature is required';
        }
    }

    protected function prepareInspectionDataForPreview()
    {
        $data = $this->inspectionData;
        $data['photos'] = $this->photos;
        $data['inspector_signature'] = $this->inspectorSignature;
        $data['customer_signature'] = $this->customerSignature;
        
        return $data;
    }

    protected function prepareInspectionDataForSubmission()
    {
        $data = $this->inspectionData;
        
        // Filter out empty condition entries
        $data['exterior_condition'] = array_filter($data['exterior_condition'], function($condition) {
            return !empty($condition['damage']) || !empty($condition['description']);
        });
        
        $data['interior_condition'] = array_filter($data['interior_condition'], function($condition) {
            return !empty($condition['damage']) || !empty($condition['description']);
        });
        
        $data['photos'] = $this->photos;
        $data['inspector_signature'] = $this->inspectorSignature;
        $data['customer_signature'] = $this->customerSignature;
        
        return $data;
    }

    public function getFuelLevelOptions()
    {
        return [
            CarInspection::FUEL_EMPTY => 'Empty (0%)',
            CarInspection::FUEL_QUARTER => 'Quarter (25%)',
            CarInspection::FUEL_HALF => 'Half (50%)',
            CarInspection::FUEL_THREE_QUARTER => 'Three Quarter (75%)',
            CarInspection::FUEL_FULL => 'Full (100%)',
        ];
    }

    public function getDamageTypeOptions()
    {
        return [
            'scratch' => 'Scratch',
            'dent' => 'Dent',
            'crack' => 'Crack',
            'stain' => 'Stain',
            'tear' => 'Tear',
            'missing' => 'Missing',
            'broken' => 'Broken',
            'other' => 'Other',
        ];
    }

    public function render()
    {
        $preparationData = $this->checkoutService->getCheckoutPreparationData($this->booking);
        
        return view('livewire.admin.vehicle-checkout-form', [
            'preparationData' => $preparationData,
            'fuelLevelOptions' => $this->getFuelLevelOptions(),
            'damageTypeOptions' => $this->getDamageTypeOptions(),
        ]);
    }
}