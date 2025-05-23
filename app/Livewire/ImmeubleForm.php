<?php

namespace App\Livewire;

use App\Models\Immeuble;
use Livewire\Component;

class ImmeubleForm extends Component
{
    public $nom, $ville, $code_postal, $adresse, $cotisation_mensuelle;

    protected $rules = [
        'nom' => 'required|string|max:255',
        'ville' => 'required|string|max:255',
        'code_postal' => 'required|string|max:10',
        'adresse' => 'required|string',
        'cotisation_mensuelle' => 'required|numeric|min:0',
    ];

    public function save()
    {
        $this->validate();

        Immeuble::create([
            'nom' => $this->nom,
            'ville' => $this->ville,
            'code_postal' => $this->code_postal,
            'adresse' => $this->adresse,
            'cotisation_mensuelle' => $this->cotisation_mensuelle,
        ]);

        // Redirection vers la page d'ajout d'appartement
        return redirect()->to('/appartements/ajouter');
    }

    public function render()
    {
        return view('livewire.immeuble-form');
    }
}
