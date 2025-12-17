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
                'name' => 'Dasbor',
                'route' => 'customer.dashboard',
                'icon' => 'home',
            ],
            [
                'name' => 'Pemesanan Saya',
                'route' => 'customer.bookings',
                'icon' => 'clipboard',
            ],
            [
                'name' => 'Jelajahi Kendaraan',
                'route' => 'vehicles.catalog',
                'icon' => 'car',
            ],
        ];

        return view('livewire.layout.customer-sidebar', compact('menuItems'));
    }
}
