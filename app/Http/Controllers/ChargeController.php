<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use Illuminate\Http\Request;
use App\Models\Residence;
use App\Models\Immeuble;

class ChargeController extends Controller
{
    // Afficher la liste des charges
    public function index()
    {
        $charges = Charge::all();
        return view('livewire.charges', compact('charges'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        $residences = Residence::all();
        $immeubles = Immeuble::all();

        return view('livewire.charges-ajouter', compact('residences', 'immeubles'));

    }

    // Enregistrer une nouvelle charge
    public function store(Request $request)
    {
        $validated = $request->validate([
            'immeuble_id' => 'required|integer|exists:immeuble,id',
            'id_residence' => 'nullable|integer|exists:residences,id',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'montant' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        Charge::create($validated);

        return redirect()->route('charges.index')->with('success', 'Charge ajoutée avec succès.');
    }

    // Afficher le formulaire d'édition
    public function edit(Charge $charge)
    {
        $residences = Residence::all();
        $immeubles = Immeuble::all();

        return view('charges.edit', compact('charge', 'residences', 'immeubles'));
    }

    // Mettre à jour une charge
    public function update(Request $request, Charge $charge)
    {
        $validated = $request->validate([
            'immeuble_id' => 'required|integer|exists:immeuble,id',
            'id_residence' => 'nullable|integer|exists:residences,id',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'montant' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        $charge->update($validated);

        return redirect()->route('charges.index')->with('success', 'Charge mise à jour avec succès.');
    }

    // Supprimer une charge
    public function destroy(Charge $charge)
    {
        $charge->delete();

        return redirect()->route('charges.index')->with('success', 'Charge supprimée avec succès.');
    }
}
