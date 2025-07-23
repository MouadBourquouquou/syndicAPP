<?php

namespace App\Http\Controllers\Assistant;
use App\Http\Controllers\Controller;
use App\Models\Charge;
use App\Models\Immeuble;
use App\Models\Residence;
use Illuminate\Http\Request;
use App\Traits\NotifiesUsersOfActions;

class ChargeController extends Controller
{
    use NotifiesUsersOfActions;
    public function index()
{
    $user = auth()->user();

    // Récupérer les immeubles de l'utilisateur avec leurs résidences
    $immeubles = $user->immeubles()->with('residence')->get();

    // Extraire les IDs nécessaires
    $immeubleIds = $immeubles->pluck('id')->toArray();
    $residenceIds = $immeubles->pluck('residence.id')->unique()->filter()->toArray();

    // Récupérer le filtre d'état depuis l'URL (payée / non payée)
    $etat = request('etat');

    // Construire la requête Charges avec les relations et le filtre
    $charges = Charge::with(['immeuble', 'residence'])
        ->where(function ($query) use ($immeubleIds, $residenceIds) {
            $query->whereIn('immeuble_id', $immeubleIds)
                  ->orWhereIn('id_residence', $residenceIds);
        })
        ->when($etat, function ($query) use ($etat) {
            $query->where('etat', $etat);
        })
        ->latest()
        ->paginate(10)
        ->appends(request()->query()); // garde les paramètres dans la pagination

    return view('livewire.charges', compact('charges', 'residenceIds', 'immeubleIds'));
}


    public function create()
    {
        $user = auth()->user();

        $immeubles = $user->immeubles()->with('residence')->get();
        $residences = $immeubles->pluck('residence')->unique('id')->filter();

        return view('livewire.charges-ajouter', compact('residences', 'immeubles'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();


        $immeubleIds = $user->immeubles->pluck('id')->toArray();
        $residenceIds = $user->immeubles->pluck('residence.id')->unique()->filter()->toArray();

        $validated = $request->validate([
            'immeuble_id' => ['required', 'integer', 'exists:immeuble,id'],
            'id_residence' => ['nullable', 'integer', 'exists:residences,id'],
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'montant' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);



        // Vérifier que l'employé a le droit sur l'immeuble/résidence
        if (!in_array($validated['immeuble_id'], $immeubleIds) ||
            ($validated['id_residence'] && !in_array($validated['id_residence'], $residenceIds))) {
            abort(403, 'Vous n\'êtes pas autorisé à créer une charge pour cet immeuble ou cette résidence.');
        }

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

       try {
            // Create the charge
            Charge::create($validated);
            $charge = Charge::latest()->first();

            // Send notification
            $this->notifyUser(' a ajouté', $charge, ' une Charge');

            return redirect()->route('assistant.charges.index')->with('success', 'Charge ajoutée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de l\'ajout de la charge.');
        }
    }

    public function edit(Charge $charge)
    {
        $user = auth()->user();

        $immeubles = $user->immeubles()->with('residence')->get();
        $immeubleIds = $immeubles->pluck('id')->toArray();
        $residenceIds = $immeubles->pluck('residence.id')->unique()->filter()->toArray();

        // Vérification
        if (!in_array($charge->immeuble_id, $immeubleIds) ||
            ($charge->id_residence && !in_array($charge->id_residence, $residenceIds))) {
            abort(403, 'Vous ne pouvez pas modifier cette charge.');
        }

        $residences = $immeubles->pluck('residence')->unique('id')->filter();

        return view('charges.edit', compact('charge', 'residences', 'immeubles'));
    }

    public function update(Request $request, Charge $charge)
    {
        $user = auth()->user();

        $immeubleIds = $user->immeubles->pluck('id')->toArray();
        $residenceIds = $user->immeubles->pluck('residence.id')->unique()->filter()->toArray();

        if (!in_array($charge->immeuble_id, $immeubleIds) ||
            ($charge->id_residence && !in_array($charge->id_residence, $residenceIds))) {
            abort(403, 'Vous ne pouvez pas modifier cette charge.');
        }

        $validated = $request->validate([
            'immeuble_id' => 'required|integer|exists:immeuble,id',
            'id_residence' => 'nullable|integer|exists:residences,id',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'montant' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        $charge->update($validated);
        $this->notifyUser(' a mis à jour'. $appartement. ' une Appartement');

        return redirect()->route('assistant.charges.index')->with('success', 'Charge mise à jour avec succès.');
    }

    public function destroy(Charge $charge)
    {
        $user = auth()->user();

        $immeubleIds = $user->immeubles->pluck('id')->toArray();
        $residenceIds = $user->immeubles->pluck('residence.id')->unique()->filter()->toArray();

        if (!in_array($charge->immeuble_id, $immeubleIds) ||
            ($charge->id_residence && !in_array($charge->id_residence, $residenceIds))) {
            abort(403, 'Vous ne pouvez pas supprimer cette charge.');
        }

        $charge->delete();

        return redirect()->route('assistant.charges.index')->with('success', 'Charge supprimée avec succès.');
    }

    public function show(Charge $charge)
    {
        $user = auth()->user();

        $immeubleIds = $user->immeubles->pluck('id')->toArray();
        $residenceIds = $user->immeubles->pluck('residence.id')->unique()->filter()->toArray();

        if (!in_array($charge->immeuble_id, $immeubleIds) ||
            ($charge->id_residence && !in_array($charge->id_residence, $residenceIds))) {
            abort(403, 'Vous ne pouvez pas consulter cette charge.');
        }

        return view('charges.show', compact('charge'));
    }
}
