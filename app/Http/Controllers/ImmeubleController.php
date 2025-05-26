<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Immeuble;

class ImmeubleController extends Controller
{
    /**
     * Affiche le formulaire d'ajout d'un immeuble.
     */
    public function create()
    {
        return view('immeubles.ajouter'); // suppose que ta vue est dans resources/views/immeubles/ajouter.blade.php
    }

    /**
     * Enregistre un nouvel immeuble.
     */
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'code_postal' => 'required|numeric|digits_between:4,10',
            'adresse' => 'required|string|max:255',
            'cotisation' => 'required|numeric|min:0',
            'caisse' => 'required|numeric|min:0',
            'a_residence' => 'required|in:oui,non',
            'residence_id' => 'nullable|exists:residences,id'
        ]);

        // Création de l’immeuble
        Immeuble::create([
            'nom' => $validated['nom'],
            'ville' => $validated['ville'],
            'code_postal' => $validated['code_postal'],
            'adresse' => $validated['adresse'],
            'cotisation' => $validated['cotisation'],
            'caisse' => $validated['caisse'],
            'residence_id' => $validated['a_residence'] === 'oui' ? $validated['residence_id'] : null,
        ]);

        return redirect()->back()->with('success', 'Immeuble ajouté avec succès.');
    }
}
