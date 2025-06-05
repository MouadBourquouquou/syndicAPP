<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;
use PDF;
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

    $appartement = \App\Models\Appartement::with('immeuble')->findOrFail($validated['id_A']);
    $immeuble = $appartement->immeuble;

    // Construire un tableau des dates mois payés (format 'YYYY-MM-01')
    $moisPayes = array_map(function ($mois) use ($validated) {
        return sprintf('%04d-%02d-01', $validated['annee'], $mois);
    }, $validated['mois']);

    // Calcul montant total = cotisation mensuelle * nombre de mois
    $montantTotal = $appartement->montant_cotisation_mensuelle * count($moisPayes);

    $paiement = new Paiement();
    $paiement->id_A = $validated['id_A'];
    $paiement->statut = 'payé';
    $paiement->id_S = auth()->user()->id_S ?? null;

    // Récupérer id_E via pivot employe_immeuble
    $employeImmeuble = \DB::table('employe_immeuble')->where('immeuble_id', $immeuble->id)->first();
    $paiement->id_E = $employeImmeuble ? $employeImmeuble->employe_id : null;

    // Sauvegarder les mois payés au format JSON dans la colonne mois_payes
    $paiement->mois_payes = json_encode($moisPayes);

    $paiement->save();

    return redirect()->route('paiements.facture', $paiement->id);
}



    public function facture($id)
    {
       $paiement = Paiement::with('appartement')->findOrFail($id);

        $pdf = PDF::loadView('paiements.facture' , compact('paiement'));

        // Pour afficher le PDF directement dans le navigateur sans forcer le téléchargement
        return $pdf->stream('facture.pdf');

        // Si tu préfères forcer le téléchargement, utilise plutôt :
        // return $pdf->download('facture.pdf');
    
}
}
