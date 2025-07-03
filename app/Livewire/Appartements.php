<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Appartement;  // Import du modèle Appartement

class Appartements extends Component
{
    public $appartements;
    public function mount()
    {
        // Récupère tous les appartements avec leurs immeubles associés
        $this->appartements = Appartement::with('immeuble')->get();
    }

    public function render()
    {
        return view('livewire.appartements', [
            'appartements' => $this->appartements,
        ]);
    }
}
