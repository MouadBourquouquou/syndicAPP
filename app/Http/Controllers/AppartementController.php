<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appartement;

class AppartementController extends Controller
{
    /**
     * Enregistre un nouvel appartement.
     */
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'immeuble_id' => 'required|exists:immeubles,id',
            'numero' => 'required|string|max:10',
            'surface' => 'required|numeric|min:1',
            'dernier_mois_paye' => 'required|date_format:Y-m',
            'telephone' => 'required|string|min:10|max:20',
        ]);

        // Création de l'appartement
        Appartement::create([
            'immeuble_id' => $validated['immeuble_id'],
            'numero' => $validated['numero'],
            'surface' => $validated['surface'],
            'dernier_mois_paye' => $validated['dernier_mois_paye'] . '-01', // converti mois en date complète
            'telephone' => $validated['telephone'],
        ]);

        return redirect()->back()->with('success', 'Appartement ajouté avec succès.');
    }
}
