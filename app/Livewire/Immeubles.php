<?php

namespace App\Livewire;

use Livewire\Component;

class Immeuble extends Component
{
    public $immeuble;

    public function mount()
    {
        // Données statiques simulant les immeubles
        $this->immeuble = [
            (object)[ 'nom' => 'Immeuble Alpha', 'adresse' => '123 Rue A' ],
            (object)[ 'nom' => 'Immeuble Beta', 'adresse' => '456 Rue B' ],
            (object)[ 'nom' => 'Immeuble Gamma', 'adresse' => '789 Rue C' ],
        ];
    }

    public function render()
    {
        return view('livewire.immeubles');
    }
}
