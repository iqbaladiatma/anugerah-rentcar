<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class SuperAdminDashboard extends Component
{
    public $activeSessions = [];
    public $allUsers = [];
    public $systemSettings = [];
    public $selectedUserId = null;
    public $showUserModal = false;
    public $showSettingsModal = false;
    public $selectedSetting = null;
    public $settingValue = '';

    protected $listeners = ['refreshSessions' => '$refresh'];

    public function mount()
    {
        $this->loadActiveSessions();
        $this->loadAllUsers();
        $this->loadSystemSettings();
    }

    public function loadActiveSessions()
    {
        $this->activeSessions = \App\Models\ActiveSession::where('last_activity', '>=', now()->subMinutes(5))
            ->with('user')
            ->orderBy('last_activity', 'desc')
            ->get()
            ->map(function ($session) {
                return [
                    'id' => $session->id,
                    'user_name' => $session->user ? $session->user->name : 'Guest',
                    'user_email' => $session->user ? $session->user->email : 'N/A',
                    'user_role' => $session->user ? $session->user->role : 'N/A',
                    'ip_address' => $session->ip_address,
                    'browser' => $session->browser,
                    'platform' => $session->platform,
                    'device' => $session->device,
                    'current_page' => $session->current_page,
                    'last_activity' => $session->last_activity->diffForHumans(),
                    'is_active' => $session->last_activity->diffInMinutes(now()) < 5,
                ];
            });
    }

    public function loadAllUsers()
    {
        $this->allUsers = \App\Models\User::with('driverBookings')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'role' => $user->role,
                    'is_active' => $user->is_active,
                    'created_at' => $user->created_at->format('Y-m-d H:i'),
                    'bookings_count' => $user->driverBookings->count(),
                ];
            });
    }

    public function loadSystemSettings()
    {
        $this->systemSettings = \App\Models\Setting::all()->map(function ($setting) {
            return [
                'id' => $setting->id,
                'key' => $setting->key,
                'value' => $setting->value,
                'description' => $this->getSettingDescription($setting->key),
            ];
        });
    }

    public function getSettingDescription($key)
    {
        $descriptions = [
            'company_name' => 'Nama Perusahaan',
            'company_address' => 'Alamat Perusahaan',
            'company_phone' => 'Telepon Perusahaan',
            'company_email' => 'Email Perusahaan',
            'company_logo' => 'Logo Perusahaan',
            'tax_rate' => 'Tarif Pajak (%)',
            'currency' => 'Mata Uang',
            'timezone' => 'Zona Waktu',
        ];

        return $descriptions[$key] ?? ucwords(str_replace('_', ' ', $key));
    }

    public function toggleUserStatus($userId)
    {
        $user = \App\Models\User::find($userId);
        if ($user && !$user->isSuperAdmin()) {
            $user->is_active = !$user->is_active;
            $user->save();
            
            session()->flash('message', 'Status pengguna berhasil diubah.');
            $this->loadAllUsers();
        }
    }

    public function editSetting($settingId)
    {
        $setting = \App\Models\Setting::find($settingId);
        if ($setting) {
            $this->selectedSetting = $setting->id;
            $this->settingValue = $setting->value;
            $this->showSettingsModal = true;
        }
    }

    public function updateSetting()
    {
        if ($this->selectedSetting) {
            $setting = \App\Models\Setting::find($this->selectedSetting);
            if ($setting) {
                $setting->value = $this->settingValue;
                $setting->save();
                
                session()->flash('message', 'Pengaturan berhasil diperbarui.');
                $this->showSettingsModal = false;
                $this->loadSystemSettings();
            }
        }
    }

    public function kickSession($sessionId)
    {
        $session = \App\Models\ActiveSession::find($sessionId);
        if ($session) {
            $session->delete();
            session()->flash('message', 'Sesi pengguna berhasil diputus.');
            $this->loadActiveSessions();
        }
    }

    public function render()
    {
        return view('livewire.admin.super-admin-dashboard')
            ->layout('layouts.admin');
    }
}
