<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use App\Models\Penalty;
use App\Models\RentalPackage;
use Livewire\Component;

class PricingSettings extends Component
{
    // General Settings
    public $late_penalty_per_hour;
    public $buffer_time_hours;
    public $member_discount_percentage;

    // Penalties
    public $penaltyId;
    public $penaltyForm = [
        'name' => '',
        'amount' => '',
        'type' => 'fixed',
        'description' => '',
        'is_active' => true,
    ];
    public $showPenaltyModal = false;

    // Rental Packages
    public $packageId;
    public $packageForm = [
        'name' => '',
        'duration_hours' => '',
        'price' => '',
        'description' => '',
        'is_active' => true,
    ];
    public $showPackageModal = false;

    protected $rules = [
        'late_penalty_per_hour' => 'required|numeric|min:0|max:999999.99',
        'buffer_time_hours' => 'required|integer|min:0|max:24',
        'member_discount_percentage' => 'required|numeric|min:0|max:100',
    ];

    protected $messages = [
        'late_penalty_per_hour.required' => 'Tarif denda keterlambatan wajib diisi.',
        'late_penalty_per_hour.numeric' => 'Tarif denda keterlambatan harus berupa angka.',
        'late_penalty_per_hour.min' => 'Tarif denda keterlambatan tidak boleh negatif.',
        'late_penalty_per_hour.max' => 'Tarif denda keterlambatan terlalu tinggi.',
        'buffer_time_hours.required' => 'Waktu jeda wajib diisi.',
        'buffer_time_hours.integer' => 'Waktu jeda harus berupa angka bulat.',
        'buffer_time_hours.min' => 'Waktu jeda tidak boleh negatif.',
        'buffer_time_hours.max' => 'Waktu jeda tidak boleh melebihi 24 jam.',
        'member_discount_percentage.required' => 'Persentase diskon member wajib diisi.',
        'member_discount_percentage.numeric' => 'Persentase diskon member harus berupa angka.',
        'member_discount_percentage.min' => 'Persentase diskon member tidak boleh negatif.',
        'member_discount_percentage.max' => 'Persentase diskon member tidak boleh melebihi 100%.',
        'penaltyForm.name.required' => 'Nama denda wajib diisi.',
        'penaltyForm.amount.required' => 'Jumlah denda wajib diisi.',
        'penaltyForm.amount.numeric' => 'Jumlah denda harus berupa angka.',
        'penaltyForm.type.required' => 'Tipe denda wajib dipilih.',
        'packageForm.name.required' => 'Nama paket wajib diisi.',
        'packageForm.duration_hours.required' => 'Durasi paket wajib diisi.',
        'packageForm.duration_hours.integer' => 'Durasi paket harus berupa angka bulat.',
        'packageForm.price.required' => 'Harga paket wajib diisi.',
        'packageForm.price.numeric' => 'Harga paket harus berupa angka.',
    ];

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        $settings = Setting::current();
        $this->late_penalty_per_hour = $settings->late_penalty_per_hour;
        $this->buffer_time_hours = $settings->buffer_time_hours;
        $this->member_discount_percentage = $settings->member_discount_percentage;
    }

    // General Settings Methods
    public function saveSettings()
    {
        $this->validate();

        try {
            $settings = Setting::current();
            $oldValues = $settings->toArray();

            $data = [
                'late_penalty_per_hour' => $this->late_penalty_per_hour,
                'buffer_time_hours' => $this->buffer_time_hours,
                'member_discount_percentage' => $this->member_discount_percentage,
            ];

            $settings = Setting::updateSettings($data);

            $this->logSettingChange('pricing_configuration', $oldValues, $settings->toArray());

            session()->flash('success', 'Konfigurasi harga berhasil diperbarui.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal memperbarui konfigurasi harga: ' . $e->getMessage());
        }
    }

    public function resetToDefaults()
    {
        try {
            $settings = Setting::current();
            $oldValues = $settings->toArray();

            $defaultData = [
                'late_penalty_per_hour' => 50000,
                'buffer_time_hours' => 3,
                'member_discount_percentage' => 10,
            ];

            $this->late_penalty_per_hour = $defaultData['late_penalty_per_hour'];
            $this->buffer_time_hours = $defaultData['buffer_time_hours'];
            $this->member_discount_percentage = $defaultData['member_discount_percentage'];

            $settings = Setting::updateSettings($defaultData);

            $this->logSettingChange('pricing_reset_to_defaults', $oldValues, $settings->toArray());

            session()->flash('success', 'Konfigurasi harga berhasil direset ke nilai default.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mereset konfigurasi harga: ' . $e->getMessage());
        }
    }

    // Penalty Methods
    public function createPenalty()
    {
        $this->resetPenaltyForm();
        $this->showPenaltyModal = true;
    }

    public function editPenalty($id)
    {
        $penalty = Penalty::findOrFail($id);
        $this->penaltyId = $id;
        $this->penaltyForm = [
            'name' => $penalty->name,
            'amount' => $penalty->amount,
            'type' => $penalty->type,
            'description' => $penalty->description,
            'is_active' => (bool) $penalty->is_active,
        ];
        $this->showPenaltyModal = true;
    }

    public function savePenalty()
    {
        $this->validate([
            'penaltyForm.name' => 'required|string|max:255',
            'penaltyForm.amount' => 'required|numeric|min:0',
            'penaltyForm.type' => 'required|in:fixed,hourly,daily',
            'penaltyForm.description' => 'nullable|string',
            'penaltyForm.is_active' => 'boolean',
        ]);

        if ($this->penaltyId) {
            $penalty = Penalty::findOrFail($this->penaltyId);
            $penalty->update($this->penaltyForm);
            session()->flash('success', 'Denda berhasil diperbarui.');
        } else {
            Penalty::create($this->penaltyForm);
            session()->flash('success', 'Denda berhasil dibuat.');
        }

        $this->showPenaltyModal = false;
    }

    public function deletePenalty($id)
    {
        Penalty::findOrFail($id)->delete();
        session()->flash('success', 'Denda berhasil dihapus.');
    }

    public function resetPenaltyForm()
    {
        $this->penaltyId = null;
        $this->penaltyForm = [
            'name' => '',
            'amount' => '',
            'type' => 'fixed',
            'description' => '',
            'is_active' => true,
        ];
    }

    // Rental Package Methods
    public function createPackage()
    {
        $this->resetPackageForm();
        $this->showPackageModal = true;
    }

    public function editPackage($id)
    {
        $package = RentalPackage::findOrFail($id);
        $this->packageId = $id;
        $this->packageForm = [
            'name' => $package->name,
            'duration_hours' => $package->duration_hours,
            'price' => $package->price,
            'description' => $package->description,
            'is_active' => (bool) $package->is_active,
        ];
        $this->showPackageModal = true;
    }

    public function savePackage()
    {
        $this->validate([
            'packageForm.name' => 'required|string|max:255',
            'packageForm.duration_hours' => 'required|integer|min:1',
            'packageForm.price' => 'required|numeric|min:0',
            'packageForm.description' => 'nullable|string',
            'packageForm.is_active' => 'boolean',
        ]);

        if ($this->packageId) {
            $package = RentalPackage::findOrFail($this->packageId);
            $package->update($this->packageForm);
            session()->flash('success', 'Paket sewa berhasil diperbarui.');
        } else {
            RentalPackage::create($this->packageForm);
            session()->flash('success', 'Paket sewa berhasil dibuat.');
        }

        $this->showPackageModal = false;
    }

    public function deletePackage($id)
    {
        RentalPackage::findOrFail($id)->delete();
        session()->flash('success', 'Paket sewa berhasil dihapus.');
    }

    public function resetPackageForm()
    {
        $this->packageId = null;
        $this->packageForm = [
            'name' => '',
            'duration_hours' => '',
            'price' => '',
            'description' => '',
            'is_active' => true,
        ];
    }

    private function logSettingChange(string $action, array $oldValues, array $newValues)
    {
        \Log::info('Settings Change', [
            'action' => $action,
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'timestamp' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public function render()
    {
        return view('livewire.admin.pricing-settings', [
            'penalties' => Penalty::all(),
            'rentalPackages' => RentalPackage::all(),
        ]);
    }
}