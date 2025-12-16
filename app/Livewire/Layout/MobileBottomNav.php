<?php

namespace App\Livewire\Layout;

use Livewire\Component;

class MobileBottomNav extends Component
{
    public function toggleSidebar()
    {
        $this->dispatch('toggleSidebar');
    }

    public function render()
    {
        return view('livewire.layout.mobile-bottom-nav');
    }
}
