<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Charge;  // N'oublie pas d'importer le modèle
use App\Models\Residence;
use App\Models\Immeuble;

class Charges extends Component
{
    public $charges; // pluriel car c’est une collection

    public function mount()
    {
        // Récupérer toutes les charges depuis la base de données
        $this->charges = Charge::latest()->get();
    }

    
    public function render()
    {
        return view('livewire.charges-ajouter', [
            'residences' => Residence::all(),
            'immeubles' => Immeuble::all()
        ]);
    }
    
        
}