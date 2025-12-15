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
            'name' => 'Dashboard',
            'route' => 'dashboard',
            'icon' => 'home',
            'permission' => true
        ];

        // Fleet Management - Admin and Staff only
        if ($user->canManageVehicles()) {
            $menuItems[] = [
                'name' => 'Fleet Management',
                'icon' => 'truck',
                'children' => [
                    [
                        'name' => 'Vehicles',
                        'route' => 'admin.vehicles.index',
                        'icon' => 'car'
                    ],
                    [
                        'name' => 'Maintenance',
                        'route' => 'admin.maintenance.index',
                        'icon' => 'wrench'
                    ],
                    [
                        'name' => 'Availability Timeline',
                        'route' => 'admin.availability.timeline',
                        'icon' => 'calendar'
                    ]
                ]
            ];
        }

        // Customer Management - Admin and Staff only
        if ($user->canManageCustomers()) {
            $menuItems[] = [
                'name' => 'Customer Management',
                'icon' => 'users',
                'children' => [
                    [
                        'name' => 'Customers',
                        'route' => 'admin.customers.index',
                        'icon' => 'user'
                    ],
                    [
                        'name' => 'Member Management',
                        'route' => 'admin.customers.members',
                        'icon' => 'star'
                    ],
                    [
                        'name' => 'Blacklist',
                        'route' => 'admin.customers.blacklist',
                        'icon' => 'ban'
                    ]
                ]
            ];
        }

        // Booking Management - Admin and Staff only
        if ($user->canManageBookings()) {
            $menuItems[] = [
                'name' => 'Booking Management',
                'icon' => 'clipboard-list',
                'children' => [
                    [
                        'name' => 'All Bookings',
                        'route' => 'admin.bookings.index',
                        'icon' => 'list'
                    ],
                    [
                        'name' => 'New Booking',
                        'route' => 'admin.bookings.create',
                        'icon' => 'plus'
                    ]
                ]
            ];
        }

        // Financial Management - Admin and Staff only
        if ($user->canViewReports()) {
            $menuItems[] = [
                'name' => 'Financial Management',
                'icon' => 'currency-dollar',
                'children' => [
                    [
                        'name' => 'Expenses',
                        'route' => 'admin.expenses.index',
                        'icon' => 'receipt-tax'
                    ],
                    [
                        'name' => 'Expense Analytics',
                        'route' => 'admin.expenses.analytics-view',
                        'icon' => 'chart-bar'
                    ],
                    [
                        'name' => 'Reports',
                        'route' => 'admin.reports.index',
                        'icon' => 'chart-bar'
                    ],
                    [
                        'name' => 'Profit Analysis',
                        'route' => 'admin.reports.profit',
                        'icon' => 'trending-up'
                    ]
                ]
            ];
        }

        // System Settings - Admin only
        if ($user->canManageSettings()) {
            $menuItems[] = [
                'name' => 'System Settings',
                'icon' => 'cog',
                'children' => [
                    [
                        'name' => 'Company Settings',
                        'route' => 'admin.settings.company',
                        'icon' => 'office-building'
                    ],
                    [
                        'name' => 'User Management',
                        'route' => 'admin.settings.users',
                        'icon' => 'user-group'
                    ],
                    [
                        'name' => 'Pricing Configuration',
                        'route' => 'admin.settings.pricing',
                        'icon' => 'calculator'
                    ],
                    [
                        'name' => 'System Configuration',
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