<?php

namespace App\Livewire\Public;

use App\Models\Car;
use Livewire\Component;

class PopularVehicles extends Component
{
    public function render()
    {
        $popularVehicles = Car::where('status', 'available')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('livewire.public.popular-vehicles', [
            'vehicles' => $popularVehicles
        ]);
    }
}