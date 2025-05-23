<?php

namespace App\Livewire;

use Livewire\Component;

class Employes extends Component
{
    public $employes;

    public function mount()
    {
        // Données statiques simulant les employés
        $this->employes = [
            (object)['nom' => 'Alice Dupont', 'poste' => 'Gestionnaire'],
            (object)['nom' => 'Bob Martin', 'poste' => 'Technicien'],
            (object)['nom' => 'Claire Bernard', 'poste' => 'Secrétaire'],
        ];
    }

    public function render()
    {
        return view('livewire.employes');
    }
}
