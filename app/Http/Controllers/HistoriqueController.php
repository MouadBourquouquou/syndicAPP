<?php
namespace App\Http\Livewire;

use Livewire\Component;

class Historique extends Component
{
    public $historiques = [
        ['id' => 1, 'user' => 'Admin', 'action' => 'Connexion', 'date' => '2025-05-25 08:00'],
        ['id' => 2, 'user' => 'Jean Dupont', 'action' => 'Ajout d\'un immeuble', 'date' => '2025-05-25 09:15'],
        ['id' => 3, 'user' => 'Marie Curie', 'action' => 'Modification d\'un appartement', 'date' => '2025-05-25 10:30'],
    ];

    public function render()
    {
        return view('livewire.historique');
    }
}
