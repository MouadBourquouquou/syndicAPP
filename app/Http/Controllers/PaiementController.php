<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\Appartement;
use PDF;
use Carbon\Carbon;

class PaiementController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_A' => 'required|exists:appartements,id_A',
            'annee' => 'required|digits:4|integer|min:2000|max:2100',
            'mois' => 'required|array|min:1',
            'mois.*' => 'integer|between:1,12',
        ]);

        $appartement = Appartement::with('immeuble')->findOrFail($validated['id_A']);
        $immeuble = $appartement->immeuble;

        $moisPayes = array_map(function ($mois) use ($validated) {
            return sprintf('%04d-%02d-01', $validated['annee'], $mois);
        }, $validated['mois']);

        $montantTotal = $appartement->montant_cotisation_mensuelle * count($moisPayes);

        $paiement = new Paiement();
        $paiement->id_A = $validated['id_A'];
        $paiement->id_S = auth()->user()->id_S ?? null;

        $employeImmeuble = \DB::table('employe_immeuble')->where('immeuble_id', $immeuble->id)->first();
        $paiement->id_E = $employeImmeuble->employe_id ?? null;

        $paiement->mois_payes = json_encode($moisPayes);
        $paiement->montant = $montantTotal;
        $paiement->save();

        return redirect()->route('paiements.facture', $paiement->id);
    }

    public function facture($id)
    {
        $paiement = Paiement::with('appartement')->findOrFail($id);
        $pdf = PDF::loadView('paiements.facture', compact('paiement'));
        return $pdf->stream('facture.pdf');
    }

    public function historique(Request $request)
    {
        $filtre = $request->query('filtre');
        $moisActuel = now()->startOfMonth()->format('Y-m-d');

        $paiements = Paiement::with('appartement.immeuble.residence');

        if ($filtre === 'paye') {
            $paiements = $paiements->whereNotNull('mois_payes');
        } elseif ($filtre === 'retard') {
            $paiements = $paiements->where(function ($query) use ($moisActuel) {
                $query->whereNull('mois_payes')
                      ->orWhereRaw("JSON_SEARCH(mois_payes, 'one', ? ) IS NULL", [$moisActuel]);
            });
        }

        $paiements = $paiements->orderBy('created_at', 'desc')->get();

        return view('livewire.historique', compact('paiements'));
    }

    public function index(Request $request)
    {
        $filtre = $request->input('filtre');
        $moisActuel = Carbon::now()->format('Y-m'); // ex: 2025-06

        // On récupère tous les paiements avec les relations nécessaires
        $paiements = Paiement::with('appartement.immeuble.residence')->get();

        // Filtrage selon les critères
        if ($filtre === 'complet') {
            $paiements = $paiements->filter(function ($paiement) {
                $moisPayes = json_decode($paiement->mois_payes);
                return count($moisPayes) === 12;
            });
        } elseif ($filtre === 'incomplet') {
            $paiements = $paiements->filter(function ($paiement) {
                $moisPayes = json_decode($paiement->mois_payes);
                return count($moisPayes) > 0 && count($moisPayes) < 12;
            });
        } elseif ($filtre === 'retard') {
            $paiements = $paiements->filter(function ($paiement) use ($moisActuel) {
                $moisPayes = collect(json_decode($paiement->mois_payes))
                    ->map(fn($mois) => Carbon::parse($mois)->format('Y-m'));
                return !$moisPayes->contains($moisActuel);
            });
        }

        return view('livewire.historique', compact('paiements'));

    }
}
