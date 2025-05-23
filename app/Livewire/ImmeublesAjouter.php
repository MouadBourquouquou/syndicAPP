<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Immeuble; // Pour récupérer la liste des immeubles
use App\Models\Appartement; // Modèle appartement

class AppartementsAjouter extends Component
{
    public $immeuble_id, $numero, $surface, $dernier_mois_paye, $telephone;

    protected $rules = [
        'immeuble_id' => 'required|exists:immeubles,id',
        'numero' => 'required|string|max:50',
        'surface' => 'required|numeric|min:0',
        'dernier_mois_paye' => 'required|date_format:Y-m',
        'telephone' => 'required|string|max:20',
    ];

    public function ajouter()
    {
        $this->validate();

        Appartement::create([
            'immeuble_id' => $this->immeuble_id,
            'numero' => $this->numero,
            'surface' => $this->surface,
            'dernier_mois_paye' => $this->dernier_mois_paye,
            'telephone' => $this->telephone,
        ]);

        session()->flash('success', 'Appartement ajouté avec succès !');

        // Reset formulaire si besoin
        $this->reset(['immeuble_id', 'numero', 'surface', 'dernier_mois_paye', 'telephone']);
    }

    public function render()
    {
        // Passer la liste des immeubles à la vue
        $immeubles = Immeuble::all();
        return view('livewire.appartements-ajouter', compact('immeubles'));
    }
}
