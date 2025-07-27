<?php

namespace App\Http\Controllers\Assistant;
use App\Http\Controllers\Controller;
use App\Models\Charge;
use App\Models\Immeuble;
use App\Models\Residence;
use Illuminate\Http\Request;
use App\Traits\NotifiesUsersOfActions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    if (!in_array($validated['immeuble_id'], $immeubleIds) ||
        ($validated['id_residence'] && !in_array($validated['id_residence'], $residenceIds))) {
        abort(403, 'Non autorisé à ajouter une charge pour cet immeuble ou résidence.');
    }

    $immeuble = Immeuble::find($validated['immeuble_id']);
    if (!$immeuble) {
        return redirect()->back()->with('error', 'Immeuble introuvable.');
    }

    $caisse = $immeuble->caisse;
    $montant = $validated['montant'];
    $action = $request->input('action'); // "ajouter" ou "ajouter_et_payer"

    if ($action === 'ajouter_et_payer') {
        if ($caisse >= $montant) {
            $validated['etat'] = 'payée';
            $immeuble->update(['caisse' => $caisse - $montant]);
        } else {
            $validated['etat'] = 'non payée';
            try {
                $charge = Charge::create($validated);
                $this->notifyUser(" a ajouté une charge non payée, fonds insuffisants", $charge, '', [], 'charge');
                return redirect()->route('assistant.charges.index')
                    ->with('warning', 'Fonds insuffisants. La charge a été enregistrée comme non payée.');
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Erreur lors de l\'ajout.');
            }
        }
    } else {
        $validated['etat'] = 'non payée';
    }

    try {
        $charge = Charge::create($validated);
        $message = ($validated['etat'] === 'payée') ? " a ajouté et payé" : " a ajouté une charge non payée";
        $this->notifyUser($message, $charge, '', [], 'charge');

        return redirect()->route('assistant.charges.index')
            ->with('success', 'Charge ajoutée' . ($validated['etat'] === 'payée' ? ' et payée' : '') . ' avec succès.');
    } catch (\Exception $e) {
        return redirect()->back()->withInput()->with('error', 'Erreur lors de l\'ajout.');
    }
}

    public function payer($id)
{
    $charge = Charge::findOrFail($id);
    $user = auth()->user();

    // Vérifier l'accès
    if (!$user->immeubles->contains('id', $charge->immeuble_id)) {
        abort(403, 'Non autorisé à payer cette charge.');
    }

    if ($charge->etat === 'payée') {
        return redirect()->back()->with('info', 'Cette charge est déjà payée.');
    }

    $immeuble = $charge->immeuble;
    if (!$immeuble) {
        return redirect()->back()->with('error', 'Immeuble associé introuvable.');
    }

    if ($immeuble->caisse < $charge->montant) {
        return redirect()->back()->with('error', 'Fonds insuffisants pour payer cette charge.');
    }

    try {
        DB::beginTransaction();

        $immeuble->update(['caisse' => $immeuble->caisse - $charge->montant]);
        $charge->update(['etat' => 'payée']);

        DB::commit();

        $this->notifyUser(" a payé une charge", $charge, '', [], 'charge');

        return redirect()->route('assistant.charges.index')->with('success', 'Charge payée avec succès.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Erreur lors du paiement.');
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
        $recuperation = false;
        if($charge->etat === 'payée') {
            $recuperation = true;
        }
        $charge->delete();
        $immeuble = Immeuble::find($charge->immeuble_id);
        if($recuperation){
            $caisse = $immeuble->caisse;
            $caisse += $charge->montant;
            $immeuble->update(['caisse' => $caisse]);
        }
        $this->notifyUser(' a supprimé', $charge, ' une Charge', [], 'charge');

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
