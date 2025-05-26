<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Residence;

class ResidenceController extends Controller
{
    /**
     * Affiche le formulaire d'ajout de résidence.
     */
    public function create()
    {
        return view('residence.create'); // correspond à ta vue avec le formulaire
    }

    /**
     * Enregistre une nouvelle résidence en base de données.
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'ville' => 'required|string|max:100',
            'code_postal' => 'required|string|max:20',
            'nombre_immeubles' => 'required|integer|min:1',
        ]);

        // Création de la résidence
        Residence::create([
            'nom' => $request->nom,
            'adresse' => $request->adresse,
            'ville' => $request->ville,
            'code_postal' => $request->code_postal,
            'nombre_immeubles' => $request->nombre_immeubles,
        ]);

        // Redirection avec message de succès
        return redirect()->route('residence.create')->with('success', 'Résidence ajoutée avec succès.');
    }
}
