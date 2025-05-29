<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Residence;

class ResidenceController extends Controller
{
    public function store(Request $request)
    {
        // Valider les données reçues
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'nombre_immeuble' => 'required|integer|min:1',
            'ville' => 'required|string|max:100',
            'code_postal' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'cotisation_mensuelle' => 'required|numeric|min:0',
            'montant_caisse' => 'required|numeric|min:0',
        ]);

        // Créer une résidence
        Residence::create($validatedData);

        // Rediriger avec un message
        return redirect()->back()->with('success', 'Résidence ajoutée avec succès.');
    }
}
