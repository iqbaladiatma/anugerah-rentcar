<?php

namespace App\Livewire\Layout;

use Livewire\Component;

class AdminSidebar extends Component
{
    public $sidebarOpen = false;

    protected $listeners = ['toggleSidebar'];

    public function toggleSidebar()
    {
        $this->sidebarOpen = !$this->sidebarOpen;
    }

    public function closeSidebar()
    {
        $this->sidebarOpen = false;
    }

    public function getMenuItems()
    {
        $user = auth()->user();
        $menuItems = [];

        // Dashboard - Available to all authenticated users
        $menuItems[] = [
            'name' => 'Dasbor',
            'route' => 'dashboard',
            'icon' => 'home',
            'permission' => true
        ];

        // Fleet Management - Admin and Staff only
        if ($user->canManageVehicles()) {
            $menuItems[] = [
                'name' => 'Manajemen Armada',
                'icon' => 'truck',
                'children' => [
                    [
                        'name' => 'Kendaraan',
                        'route' => 'admin.vehicles.index',
                        'icon' => 'car'
                    ],
                    [
                        'name' => 'Perawatan',
                        'route' => 'admin.maintenance.index',
                        'icon' => 'wrench'
                    ],
                    [
                        'name' => 'Jadwal Ketersediaan',
                        'route' => 'admin.availability.timeline',
                        'icon' => 'calendar'
                    ]
                ]
            ];
        }

        // Customer Management - Admin and Staff only
        if ($user->canManageCustomers()) {
            $menuItems[] = [
                'name' => 'Manajemen Pelanggan',
                'icon' => 'users',
                'children' => [
                    [
                        'name' => 'Pelanggan',
                        'route' => 'admin.customers.index',
                        'icon' => 'user'
                    ],
                    [
                        'name' => 'Manajemen Anggota',
                        'route' => 'admin.customers.members',
                        'icon' => 'star'
                    ],
                    [
                        'name' => 'Daftar Hitam',
                        'route' => 'admin.customers.blacklist',
                        'icon' => 'ban'
                    ]
                ]
            ];
        }

        // Booking Management - Admin and Staff only
        if ($user->canManageBookings()) {
            $menuItems[] = [
                'name' => 'Manajemen Pemesanan',
                'icon' => 'clipboard-list',
                'children' => [
                    [
                        'name' => 'Semua Pemesanan',
                        'route' => 'admin.bookings.index',
                        'icon' => 'list'
                    ],
                    [
                        'name' => 'Pemesanan Baru',
                        'route' => 'admin.bookings.create',
                        'icon' => 'plus'
                    ]
                ]
            ];
        }

        // Financial Management - Admin and Staff only
        if ($user->canViewReports()) {
            $menuItems[] = [
                'name' => 'Manajemen Keuangan',
                'icon' => 'currency-dollar',
                'children' => [
                    [
                        'name' => 'Pengeluaran',
                        'route' => 'admin.expenses.index',
                        'icon' => 'receipt-tax'
                    ],
                    [
                        'name' => 'Analisis Pengeluaran',
                        'route' => 'admin.expenses.analytics-view',
                        'icon' => 'chart-bar'
                    ],
                    [
                        'name' => 'Laporan',
                        'route' => 'admin.reports.index',
                        'icon' => 'chart-bar'
                    ],
                    [
                        'name' => 'Analisis Profitabilitas',
                        'route' => 'admin.reports.profitability',
                        'icon' => 'trending-up'
                    ]
                ]
            ];
        }

        // System Settings - Admin only
        if ($user->canManageSettings()) {
            $menuItems[] = [
                'name' => 'Pengaturan Sistem',
                'icon' => 'cog',
                'children' => [
                    [
                        'name' => 'Pengaturan Perusahaan',
                        'route' => 'admin.settings.company',
                        'icon' => 'office-building'
                    ],
                    [
                        'name' => 'Manajemen Pengguna',
                        'route' => 'admin.settings.users',
                        'icon' => 'user-group'
                    ],
                    [
                        'name' => 'Konfigurasi Harga',
                        'route' => 'admin.settings.pricing',
                        'icon' => 'calculator'
                    ],
                    [
                        'name' => 'Konfigurasi Sistem',
                        'route' => 'admin.settings.system',
                        'icon' => 'adjustments'
                    ]
                ]
            ];
        }

        return $menuItems;
    }

    public function render()
    {
        return view('livewire.layout.admin-sidebar', [
            'menuItems' => $this->getMenuItems()
        ]);
    }
}