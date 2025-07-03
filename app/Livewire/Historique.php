<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Paiement;
use Carbon\Carbon;

class Historique extends Component
{
    public $filtreAppartement = 'tous';
    public $triSituation = 'default';
    public $paiements;

    public function mount()
    {
        $this->loadPaiements();
    }

    public function updatedFiltreAppartement()
    {
        $this->loadPaiements();
    }

    public function updatedTriSituation()
    {
        $this->loadPaiements();
    }

    public function loadPaiements()
    {
        $query = Paiement::with('appartement.immeuble.residence');

        // Filtrage
        if ($this->filtreAppartement === 'retard') {
            // Exemple: filtres selon une logique 'en retard'
            $query->whereRaw("/* ta logique ici, ex: date > now() */");
        } elseif ($this->filtreAppartement === 'avance') {
            // Exemple: filtres selon 'en avance'
            $query->whereRaw("/* ta logique ici */");
        }

        // Tri
        if ($this->triSituation === 'neg_to_pos') {
            $query->orderBy('situation', 'asc');
        } elseif ($this->triSituation === 'pos_to_neg') {
            $query->orderBy('situation', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $this->paiements = $query->get();
    }

    public function render()
    {
        return view('livewire.historique');
    }
}
