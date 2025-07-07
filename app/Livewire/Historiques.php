<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Historique;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Historiques extends Component
{
    public $filtreAnnee = 'tous';
    public $filtreMois = 'tous';
    public $triMontant = 'desc';
    public $paiements = [];

    public function mount()
    {
        $this->loadPaiements();
    }

    public function updated()
    {
        $this->loadPaiements();
    }

    public function loadPaiements()
    {
        $query = Historique::where('id_A', Auth::id())
            ->where('montant_paye', '>', 0);

        if ($this->filtreAnnee !== 'tous') {
            $query->where('annee', $this->filtreAnnee);
        }

        if ($this->filtreMois !== 'tous') {
            $query->where('mois', $this->filtreMois);
        }

        $query->orderBy('montant_paye', $this->triMontant)
              ->orderByDesc('annee')
              ->orderByDesc('mois');

        $this->paiements = $query->get()->map(function ($paiement) {
            return [
                'appartement' => [
                    'numero' => $paiement->appartement_numero ?? '-',
                    'immeuble' => [
                        'nom' => $paiement->immeuble_nom ?? '-',
                        'residence' => [
                            'nom' => $paiement->residence_nom ?? '-'
                        ]
                    ]
                ],
                'mois_payes' => [Carbon::create($paiement->annee, $paiement->mois, 1)->format('F Y')],
                'montant' => $paiement->montant_paye
            ];
        });
    }

    public function getAvailableYears()
    {
        return Historique::where('id_A', Auth::id())
            ->where('montant_paye', '>', 0)
            ->distinct()
            ->pluck('annee')
            ->sort()
            ->values();
    }

    public function render()
    {
        return view('livewire.historique', [
            'paiements' => $this->paiements,
            'availableYears' => $this->getAvailableYears()
        ]);
    }
}