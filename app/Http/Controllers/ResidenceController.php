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
            'nombre_immeubles' => 'required|integer|min:1',
            'ville' => 'required|string|max:100',
            'code_postal' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'cotisation' => 'required|numeric|min:0',
            'caisse' => 'required|numeric|min:0',
        ]);

        // Créer une résidence
        Residence::create($validatedData);

        // Rediriger avec un message
        return redirect()->back()->with('success', 'Résidence ajoutée avec succès.');
    }
    

public function index()
{
    $residences = Residence::all(); 
    return view('livewire.residences', compact('residences')); 
}
public function immeublesByResidence($id)
{
    $immeubles = Immeuble::where('residence_id', $id)->get();

    return response()->json($immeubles);
}
public function destroy($id)
    {
        $residence = Residence::findOrFail($id);
        $residence->delete();

        return redirect()->route('residences.index')->with('success', 'Résidence supprimée avec succès.');
    }
    public function update(Request $request, $id)
{
    // Validation des données reçues
    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'ville' => 'required|string|max:255',
        'adresse' => 'required|string|max:255',
        'nombre_immeubles' => 'required|integer|min:0',
    ]);

    // Recherche la résidence
    $residence = Residence::findOrFail($id);

    // Mise à jour des champs
    $residence->nom = $validated['nom'];
    $residence->ville = $validated['ville'];
    $residence->adresse = $validated['adresse'];
    $residence->nombre_immeubles = $validated['nombre_immeubles'];

    // Sauvegarde
    $residence->save();

    // Redirection avec message
    return redirect()->route('residences.index')->with('success', 'Résidence mise à jour avec succès.');
}



}
