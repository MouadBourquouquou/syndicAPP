<?php

namespace App\Livewire;

use Livewire\Component;

class DashboardChart extends Component
{
    public $chartData;

    public function mount()
    {
        // Récupérer les données du contrôleur (passées via la session ou autre)
        $this->chartData = session('chartData', [
            'labels' => [],
            'datasets' => [],
        ]);
    }

    public function render()
    {
        return view('livewire.dashboard-chart');
    }
}
