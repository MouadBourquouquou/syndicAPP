<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Immeuble;
use App\Models\Appartement;

class AppartementsAjouter extends Component
{
    public $numero;
    public $surface;
    public $dernier_mois_paye;
    public $telephone;
    public $immeuble_id;

    public $immeubles; // propriété pour stocker les immeubles

    public function mount()
    {
        // Charge tous les immeubles au chargement du composant
        $this->immeubles = Immeuble::all();
    }

    protected $rules = [
        'numero' => 'required|string|max:255',
        'surface' => 'required|numeric|min:1',
        'dernier_mois_paye' => 'required|date_format:Y-m',
        'telephone' => 'required|string|max:20',
        'immeuble_id' => 'required|exists:immeubles,id',
    ];

    public function ajouter()
    {
        $this->validate();

        Appartement::create([
            'numero' => $this->numero,
            'surface' => $this->surface,
            'dernier_mois_paye' => $this->dernier_mois_paye,
            'telephone' => $this->telephone,
            'immeuble_id' => $this->immeuble_id,
        ]);

        session()->flash('success', 'Appartement ajouté avec succès !');

        // Réinitialiser les champs
        $this->reset(['numero', 'surface', 'dernier_mois_paye', 'telephone', 'immeuble_id']);
    }

    public function render()
    {
        return view('livewire.appartements-ajouter');
    }
}
