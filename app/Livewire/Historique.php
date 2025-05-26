<?php

namespace App\Livewire;

use Livewire\Component;

class Historique extends Component
{
    public $historique = [
        ['id' => 1, 'user' => 'Dupont Jean', 'action' => 'Création d’un nouveau lot', 'date' => '25/05/2025 09:45'],
        ['id' => 2, 'user' => 'Martin Sophie', 'action' => 'Modification d’un appartement', 'date' => '24/05/2025 14:12'],
        ['id' => 3, 'user' => 'Admin', 'action' => 'Suppression d’un employé', 'date' => '23/05/2025 17:30'],
        ['id' => 4, 'user' => 'Durand Paul', 'action' => 'Ajout d’une charge', 'date' => '22/05/2025 08:20'],
    ];

    public function render()
    {
        return view('livewire.historique');
    }
}
