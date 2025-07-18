<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use Illuminate\Http\Request;
use App\Models\Residence;
use App\Models\Immeuble;
use Illuminate\Support\Facades\Auth;

class ChargeController extends Controller
{
    // Afficher la liste des charges
    public function index()
    {
        $userId = Auth::id();

        // Get all immeubles and residences owned by the user
        $immeubleIds = Immeuble::where('id_S', $userId)->pluck('id');
        $residenceIds = Residence::where('id_S', $userId)->pluck('id');

        // Fetch charges where the related immeuble or residence belongs to the current user
        $charges = Charge::with(['immeuble', 'residence'])
            ->whereIn('immeuble_id', $immeubleIds)
            ->orWhereIn('id_residence', $residenceIds)
            ->latest()
            ->paginate(10);

        return view('livewire.charges', compact('charges','residenceIds', 'immeubleIds'));
    }


    // Afficher le formulaire de création
    public function create()
    {
        $residences = Residence::where('id_S', auth::id())->get();
        $immeubles = Immeuble::where('id_S', auth::id())->get();
        return view('livewire.charges-ajouter', compact('residences', 'immeubles'));

    }

    // Enregistrer une nouvelle charge


public function store(Request $request)
{
    $userid = Auth::id();

    // Validate only the fields coming from the form
    $validated = $request->validate([
        'immeuble_id'   => 'required|integer|exists:immeuble,id',
        'id_residence'  => 'nullable|integer|exists:residences,id',
        'type'          => 'required|string|max:255',
        'description'   => 'nullable|string',
        'montant'       => 'required|numeric|min:0',
        'date'          => 'required|date',
         
    ]);
    $immeubleid=$validated['immeuble_id'];
    $caisse= Immeuble::find($immeubleid)->caisse;
    if ($caisse >= $validated['montant']) {
        immeuble::where('id', $validated['immeuble_id'])->update(['caisse' => $caisse - $validated['montant']]);
        Charge::create($validated);
return redirect()->route('charges.index')->with('success', 'Charge ajoutée avec succès.');
    }
    else{
        return redirect()->back()->with('error', 'Le montant dépasse la caisse de l\'immeuble.');
    }
  

}


    // Afficher le formulaire d'édition
    public function edit(Charge $charge)
    {
        $residences = Residence::where('id_S', auth::id())->get();
        $immeubles = Immeuble::where('id_S', auth::id())->get();
        return view('charges.edit', compact('charge', 'residences', 'immeubles'));
    }

    // Mettre à jour une charge
public function update(Request $request, Charge $charge)
{
    $validated = $request->validate([
        'immeuble_id' => 'required|integer|exists:immeuble,id',
        'residence_id' => 'nullable|integer|exists:residences,id',
        'type' => 'required|string|max:255',
        'description' => 'nullable|string',
        'montant' => 'required|numeric|min:0',
        'date' => 'required|date',
    ]);

     $immeubleid=$validated['immeuble_id'];
    $caisse= Immeuble::find($immeubleid)->caisse;
    $montantActuel = $charge->montant;

    if ($caisse >= $validated['montant']) {
        $charge->update($validated);
        immeuble::where('id', $charge->immeuble_id)->update(['caisse' => $caisse +$montantActuel- $validated['montant']]);
        return redirect()->route('charges.index')->with('success', 'Charge mise à jour avec succès.');
    }
    elseif($caisse < $validated['montant']) {
        return redirect()->back()->with('error', 'Le montant dépasse la caisse de l\'immeuble.');
    }
  

    

}


    // Supprimer une charge
    public function destroy(Charge $charge)
    {
        $charge->delete();
        $immeuble = Immeuble::find($charge->immeuble_id);
        $caisse = $immeuble->caisse;
        $caisse += $charge->montant;
        $immeuble->update(['caisse' => $caisse]);

        return redirect()->route('charges.index')->with('success', 'Charge supprimée avec succès.');
    }
}
