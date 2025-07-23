<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use Illuminate\Http\Request;
use App\Models\Residence;
use App\Models\Immeuble;
use Illuminate\Support\Facades\Auth;
use App\Traits\NotifiesUsersOfActions;

class ChargeController extends Controller
{
    use NotifiesUsersOfActions;
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

        return view('livewire.charges', compact('charges', 'residenceIds', 'immeubleIds'));
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
        $userId = Auth::id();

        // Validate the form data
        $validated = $request->validate([
            'immeuble_id'   => 'required|integer|exists:immeuble,id',
            'id_residence'  => 'nullable|integer|exists:residences,id',
            'type'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'montant'       => 'required|numeric|min:0',
            'date'          => 'required|date',
        ]);

        // Get the immeuble and its current caisse
        $immeuble = Immeuble::find($validated['immeuble_id']);

        if (!$immeuble) {
            return redirect()->back()->with('error', 'Immeuble non trouvé.');
        }

        $caisse = $immeuble->caisse;
        $montant = $validated['montant'];

        // Check if there's enough money in caisse and update etat accordingly
        if ($caisse >= $montant) {
            $validated['etat'] = 'payée';

            // Update caisse - subtract the amount
            $immeuble->update(['caisse' => $caisse - $montant]);
        } else {
            $validated['etat'] = 'non payée';
            // Don't update caisse for unpaid charges
        }

        // Add the user ID (if your charges table has a user_id field)
        // $validated['user_id'] = $userId;

        try {
            // Create the charge
            Charge::create($validated);
            $charge = Charge::latest()->first();

            // Send notification
            $this->notifyUser(' a ajouté', $charge, ' une Charge');

            return redirect()->route('charges.index')->with('success', 'Charge ajoutée avec succès.');
        } catch (\Exception $e) {
            // Log the error and return with error message
            \Log::error('Error creating charge: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Erreur lors de l\'ajout de la charge.');
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

        $immeubleid = $validated['immeuble_id'];
        $caisse = Immeuble::find($immeubleid)->caisse;
        $montantActuel = $charge->montant;
        if ($caisse >= $validated['montant']) {
            $validated['etat'] = 'payée';
        } else {
            $validated['etat'] = 'non payée';
        }


            $charge->update($validated);
            Immeuble::where('id', $charge->immeuble_id)->update(['caisse' => $caisse + $montantActuel - $validated['montant']]);
            $this->notifyUser(' a mis à jour', $charge, ' une Charge');
            return redirect()->route('charges.index')->with('success', 'Charge mise à jour avec succès.');
 
            return redirect()->back()->with('error', 'Le montant dépasse la caisse de l\'immeuble.');
        
    }


    // Supprimer une charge
    public function destroy(Charge $charge)
    {
        $charge->delete();
        $immeuble = Immeuble::find($charge->immeuble_id);
        $caisse = $immeuble->caisse;
        $caisse += $charge->montant;
        $immeuble->update(['caisse' => $caisse]);
        $this->notifyUser(' a supprimé', $charge, ' une Charge');

        return redirect()->route('charges.index')->with('success', 'Charge supprimée avec succès.');
    }
}
