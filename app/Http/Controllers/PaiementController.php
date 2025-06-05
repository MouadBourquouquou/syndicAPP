<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;
use PDF;
class PaiementController extends Controller
{
   public function store(Request $request)
{
    // Validation des données envoyées par le formulaire
    $validated = $request->validate([
        'appartement_id' => 'required|integer|exists:appartements,id_A',
        'montant' => 'required|numeric|min:0',
        'mois_paye' => 'required|date_format:Y-m-d',
        'id_E' => 'nullable|integer|exists:employes,id',
        'id_S' => 'nullable|integer|exists:syndics,id',
    ]);

    // Création du paiement avec les données validées
    $paiement = new Paiement();
    $paiement->id_A = $validated['appartement_id'];
    $paiement->montant = $validated['montant'];
    $paiement->mois_paye = $validated['mois_paye'];
    $paiement->id_E = $validated['id_E'] ?? null;
    $paiement->id_S = $validated['id_S'] ?? null;

    $paiement->save();

    // Redirection vers la route qui affiche la facture PDF du paiement créé
    return redirect()->route('paiements.facture', $paiement->id);

    return $pdf->stream('facture.pdf');


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
