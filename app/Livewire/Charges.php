<?php
namespace App\Livewire;

use Livewire\Component;

class Charges extends Component
{
    public $charges;

    public function mount()
    {
        // Données statiques pour l’exemple
        $this->charges = [
            [
                'id' => 1,
                'type' => 'Électricité',
                'description' => 'Facture du mois de mai',
                'montant' => 150.75,
                'date' => '2025-05-01',
            ],
            [
                'id' => 2,
                'type' => 'Eau',
                'description' => 'Consommation avril',
                'montant' => 80.00,
                'date' => '2025-04-28',
            ],
            [
                'id' => 3,
                'type' => 'Entretien',
                'description' => 'Nettoyage des parties communes',
                'montant' => 200.00,
                'date' => '2025-04-20',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.charges'); // Assure-toi que cette vue existe
    }
}
