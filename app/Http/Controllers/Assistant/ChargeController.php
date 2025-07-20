<?php

namespace App\Http\Controllers\Assistant;
use App\Http\Controllers\Controller;
use App\Models\Charge;
use App\Models\Immeuble;
use App\Models\Residence;
use Illuminate\Http\Request;

class ChargeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $immeubles = $user->immeubles()->with('residence')->get();
        $immeubleIds = $immeubles->pluck('id')->toArray();
        $residenceIds = $immeubles->pluck('residence.id')->unique()->filter()->toArray();

        $charges = Charge::with(['immeuble', 'residence'])
            ->where(function ($query) use ($immeubleIds, $residenceIds) {
                $query->whereIn('immeuble_id', $immeubleIds)
                      ->orWhereIn('id_residence', $residenceIds);
            })
            ->latest()
            ->paginate(10);

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

        Charge::create($validated);

        return redirect()->route('assistant.charges.index')->with('success', 'Charge ajoutée avec succès.');
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
