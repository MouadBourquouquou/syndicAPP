<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;
use PDF;
class PaiementController extends Controller
{
public function store(Request $request) 
{
    // Validation minimale
    $validated = $request->validate([
        'id_A' => 'required|exists:appartements,id_A',
    ]);

    // Récupération de l'appartement + immeuble
    $appartement = \App\Models\Appartement::with('immeuble')->findOrFail($validated['id_A']);
    $immeuble = $appartement->immeuble;

    $montant = $immeuble->cotisation_mensuelle;

    $paiement = new Paiement();
    $paiement->id_A = $validated['id_A'];
    $paiement->statut = 'payé';

    // Récupérer l'id_S du syndic connecté (user)
    $user = auth()->user();

    if (!$user) {
        return redirect()->back()->withErrors('Vous devez être connecté pour effectuer un paiement.');
    }

    $paiement->id_S = $user->id_S;

    // Récupérer l'id_E via la table pivot employe_immeuble pour cet immeuble
    $employeImmeuble = \DB::table('employe_immeuble')
        ->where('immeuble_id', $immeuble->id)
        ->first();

    // Si trouvé, mettre id_E, sinon null
    $paiement->id_E = $employeImmeuble ? $employeImmeuble->employe_id : null;

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
