<?php

namespace App\Livewire;

use Livewire\Component;

class Appartement extends Component
{
    public $appartements;

    public function mount()
    {
        // Simulation de données d'appartements avec immeuble associé
        $this->appartements = [
            (object)[
                'numero' => 'A101',
                'etage' => 1,
                'immeuble' => (object)['nom' => 'Immeuble Alpha']
            ],
            (object)[
                'numero' => 'B202',
                'etage' => 2,
                'immeuble' => (object)['nom' => 'Immeuble Beta']
            ],
            (object)[
                'numero' => 'C303',
                'etage' => 3,
                'immeuble' => (object)['nom' => 'Immeuble Gamma']
            ],
        ];
    }

    public function render()
    {
        return view('livewire.appartements');
    }
}
