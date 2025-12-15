<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\CarInspection;
use App\Services\CheckinService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class VehicleCheckinForm extends Component
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
    public array $checkoutComparison = [];

    protected CheckinService $checkinService;

    public function boot(CheckinService $checkinService)
    {
        $this->checkinService = $checkinService;
    }

    public function mount(Booking $booking)
    {
        $this->booking = $booking;
        $this->initializeInspectionData();
    }

    protected function initializeInspectionData()
    {
        $preparationData = $this->checkinService->getCheckinPreparationData($this->booking);
        
        $this->inspectionData = [
            'fuel_level' => CarInspection::FUEL_FULL,
            'odometer_reading' => $this->booking->car->current_odometer,
            'exterior_condition' => [],
            'interior_condition' => [],
            'notes' => '',
            'actual_return_date' => Carbon::now()->format('Y-m-d\TH:i'),
        ];

        // Initialize condition arrays for each checklist item
        $checklist = $this->checkinService->getInspectionChecklist();
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

        // Load checkout comparison data
        if ($preparationData['checkout_condition']) {
            $this->checkoutComparison = $preparationData['checkout_condition'];
        }
    }

    public function updatedPhotos()
    {
        $this->validate([
            'photos.*' => 'image|max:2048', // 2MB Max
        ]);
    }

    public function updatedInspectionDataActualReturnDate()
    {
        // Recalculate penalty estimate when return date changes
        $this->dispatch('penalty-updated');
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

    public function previewCheckin()
    {
        $this->validateInspectionData();
        
        if (empty($this->validationErrors)) {
            $inspectionDataWithFiles = $this->prepareInspectionDataForPreview();
            $this->summary = $this->checkinService->getCheckinSummary($this->booking, $inspectionDataWithFiles);
            $this->showSummary = true;
        }
    }

    public function processCheckin()
    {
        $this->validateInspectionData();
        
        if (!empty($this->validationErrors)) {
            return;
        }

        try {
            $inspectionDataWithFiles = $this->prepareInspectionDataForSubmission();
            $result = $this->checkinService->processCheckin($this->booking, $inspectionDataWithFiles);
            
            session()->flash('success', 'Vehicle check-in completed successfully!');
            
            // Redirect to booking details or checkin confirmation page
            return redirect()->route('admin.bookings.show', $this->booking->id);
            
        } catch (\Exception $e) {
            session()->flash('error', 'Check-in failed: ' . $e->getMessage());
        }
    }

    public function backToForm()
    {
        $this->showSummary = false;
    }

    protected function validateInspectionData()
    {
        $validation = $this->checkinService->validateInspectionData($this->inspectionData);
        $this->validationErrors = $validation['errors'];

        // Additional validation for signatures
        if (!$this->inspectorSignature) {
            $this->validationErrors[] = 'Inspector signature is required';
        }

        if (!$this->customerSignature) {
            $this->validationErrors[] = 'Customer signature is required';
        }

        // Validate actual return date
        if (empty($this->inspectionData['actual_return_date'])) {
            $this->validationErrors[] = 'Actual return date is required';
        }
    }

    protected function prepareInspectionDataForPreview()
    {
        $data = $this->inspectionData;
        $data['photos'] = $this->photos;
        $data['inspector_signature'] = $this->inspectorSignature;
        $data['customer_signature'] = $this->customerSignature;
        
        // Convert datetime string to Carbon instance
        if (!empty($data['actual_return_date'])) {
            $data['actual_return_date'] = Carbon::parse($data['actual_return_date']);
        }
        
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
        
        // Convert datetime string to Carbon instance
        if (!empty($data['actual_return_date'])) {
            $data['actual_return_date'] = Carbon::parse($data['actual_return_date']);
        }
        
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

    public function getPenaltyEstimate()
    {
        if (!empty($this->inspectionData['actual_return_date'])) {
            $actualReturnDate = Carbon::parse($this->inspectionData['actual_return_date']);
            return $this->checkinService->penaltyCalculator->calculateLatePenalty($this->booking, $actualReturnDate);
        }
        
        return ['penalty_amount' => 0];
    }

    public function render()
    {
        $preparationData = $this->checkinService->getCheckinPreparationData($this->booking);
        $penaltyEstimate = $this->getPenaltyEstimate();
        
        return view('livewire.admin.vehicle-checkin-form', [
            'preparationData' => $preparationData,
            'fuelLevelOptions' => $this->getFuelLevelOptions(),
            'damageTypeOptions' => $this->getDamageTypeOptions(),
            'penaltyEstimate' => $penaltyEstimate,
        ]);
    }
}