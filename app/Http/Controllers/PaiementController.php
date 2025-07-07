<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\Appartement;
use PDF;
use Carbon\Carbon;

class PaiementController extends Controller
{
    // ✅ Enregistrement d’un paiement
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

        // 🔸 Liste des mois déjà payés pour cet appartement
        $paiementsExistants = Paiement::where('id_A', $validated['id_A'])->get();
        $moisDejaPayes = [];
        foreach ($paiementsExistants as $paiement) {
            $moisExistants = json_decode($paiement->mois_payes, true) ?? [];
            $moisDejaPayes = array_merge($moisDejaPayes, $moisExistants);
        }

        // 🔸 Mois que l'utilisateur souhaite payer maintenant
        $moisProposes = array_map(function ($mois) use ($validated) {
            return sprintf('%04d-%02d-01', $validated['annee'], $mois);
        }, $validated['mois']);

        // 🔸 Vérification : déjà payé ou antérieur au mois en cours
        foreach ($moisProposes as $moisPropose) {
            if (in_array($moisPropose, $moisDejaPayes)) {
                return back()->withErrors(['mois' => "Le mois $moisPropose est déjà payé."])->withInput();
            }

            if (Carbon::parse($moisPropose)->lessThanOrEqualTo(Carbon::now()->startOfMonth())) {
                return back()->withErrors(['mois' => "Le paiement pour le mois $moisPropose n'est pas autorisé."])->withInput();
            }
        }

        $montantTotal = $appartement->montant_cotisation_mensuelle * count($moisProposes);

        $paiement = new Paiement();
        $paiement->id_A = $validated['id_A'];
        $paiement->id_S = auth()->id();

        $employeImmeuble = \DB::table('employe_immeuble')->where('immeuble_id', $immeuble->id)->first();
        $paiement->id_E = $employeImmeuble->employe_id ?? null;

        $paiement->mois_payes = json_encode($moisProposes);
        $paiement->montant = $montantTotal;
        $paiement->save();

        // 🔸 Mettre à jour le dernier mois payé de l'appartement
        $dernierMoisPaye = collect($moisProposes)->max();
        if (!$appartement->dernier_mois_paye || $dernierMoisPaye > $appartement->dernier_mois_paye) {
            $appartement->dernier_mois_paye = $dernierMoisPaye;
            $appartement->save();
        }

        return redirect()->route('paiements.facture', $paiement->id);
    }

    // ✅ Générer le PDF de la facture
    public function facture($id)
    {
        $paiement = Paiement::with('appartement')->findOrFail($id);
        $pdf = PDF::loadView('paiements.facture', compact('paiement'));
        return $pdf->stream('facture.pdf');
    }

    // ✅ Afficher l’historique avec filtres
    public function historique(Request $request)
    {
        $filtre = $request->query('filtre');
        $moisActuel = now()->startOfMonth()->format('Y-m-d');

        $paiements = Paiement::with('appartement.immeuble.residence')
            ->where('id_S', auth()->id());

        if ($filtre === 'paye') {
            $paiements->whereNotNull('mois_payes');
        } elseif ($filtre === 'retard') {
            $paiements->where(function ($query) use ($moisActuel) {
                $query->whereNull('mois_payes')
                      ->orWhereRaw("JSON_SEARCH(mois_payes, 'one', ? ) IS NULL", [$moisActuel]);
            });
        }

        $paiements = $paiements->orderBy('created_at', 'desc')->get();

        return view('livewire.historique', compact('paiements'));
    }

    // ✅ Index avec filtres (complet, incomplet, retard)
    public function index(Request $request)
    {
        $filtre = $request->input('filtre');
        $moisActuel = Carbon::now()->format('Y-m');

        $paiements = Paiement::with('appartement.immeuble.residence')
            ->where('id_S', auth()->id())
            ->get();

        if ($filtre === 'complet') {
            $paiements = $paiements->filter(function ($paiement) {
                $moisPayes = json_decode($paiement->mois_payes ?? '[]');
                return count($moisPayes) === 12;
            });
        } elseif ($filtre === 'incomplet') {
            $paiements = $paiements->filter(function ($paiement) {
                $moisPayes = json_decode($paiement->mois_payes ?? '[]');
                return count($moisPayes) > 0 && count($moisPayes) < 12;
            });
        } elseif ($filtre === 'retard') {
            $paiements = $paiements->filter(function ($paiement) use ($moisActuel) {
                $moisPayes = collect(json_decode($paiement->mois_payes ?? '[]'))
                    ->map(fn($mois) => Carbon::parse($mois)->format('Y-m'));
                return !$moisPayes->contains($moisActuel);
            });
        }

        return view('livewire.historique', compact('paiements'));
    }
}
