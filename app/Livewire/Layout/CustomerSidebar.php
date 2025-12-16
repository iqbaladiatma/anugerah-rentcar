<?php

namespace App\Livewire\Layout;

use Livewire\Component;

class CustomerSidebar extends Component
{
    public $sidebarOpen = false;

    public function closeSidebar()
    {
        $this->sidebarOpen = false;
    }

    public function render()
    {
        $menuItems = [
            [
                'name' => 'Dashboard',
                'route' => 'customer.dashboard',
                'icon' => 'home',
            ],
            [
                'name' => 'My Bookings',
                'route' => 'customer.bookings',
                'icon' => 'clipboard',
            ],
            [
                'name' => 'Browse Vehicles',
                'route' => 'vehicles.catalog',
                'icon' => 'car',
            ],
        ];

        return view('livewire.layout.customer-sidebar', compact('menuItems'));
    }
}
