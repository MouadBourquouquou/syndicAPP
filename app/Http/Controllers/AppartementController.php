<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appartement;
use App\Models\Immeuble;
use Illuminate\Support\Carbon;

class AppartementController extends Controller
{
    public function index() {
        $appartements = Appartement::with('immeuble')->get();
        $immeubles = Immeuble::where('id_S', auth()->id())->get();
        return view('livewire.appartements', compact('appartements', 'immeubles'));
    }
    

    public function create()
    {
        $immeubles = Immeuble::where('id_S', auth()->id())->get();
        return view('livewire.appartements-ajouter', compact('immeubles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'immeuble_id' => 'required|exists:immeuble,id',
            'numero' => 'required|string|max:20',
            'surface' => 'required|numeric|min:1',
            'CIN_A' => 'required|string|max:20',
            'Nom' => 'required|string|max:50',
            'Prenom' => 'required|string|max:50',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            'montant_cotisation_mensuelle' => 'nullable|numeric|min:0',
            'dernier_mois_paye' => 'nullable|date_format:Y-m',
        ]);

        $immeuble = Immeuble::find($request->immeuble_id);

        $cotisation = $request->montant_cotisation_mensuelle ?? $immeuble->cotisation;

        $dernierMoisPaye = $request->dernier_mois_paye
            ? Carbon::createFromFormat('Y-m', $request->dernier_mois_paye)->format('Y-m-d')
            : now()->format('Y-m-d');

        Appartement::create([
            'immeuble_id' => $request->immeuble_id,
            'numero' => $request->numero,
            'surface' => $request->surface,
            'montant_cotisation_mensuelle' => $cotisation,
            'dernier_mois_paye' => $dernierMoisPaye,
            'CIN_A' => $request->CIN_A,
            'Nom' => $request->Nom,
            'Prenom' => $request->Prenom,
            'telephone' => $request->telephone,
            'email' => $request->email,
        ]);

        return redirect()->route('appartements.create')->with('success', 'Appartement ajouté avec succès.');
    }

    public function edit($id)
    {
        $appartement = Appartement::findOrFail($id);
        $immeubles = Immeuble::where('id_S', auth()->id())->get();
        $appartements = Appartement::with('immeuble')->paginate(10);

        return view('livewire.appartements', compact('appartement', 'immeubles', 'appartements'));
    }

    public function update(Request $request, $id)
    {
        $appartement = Appartement::findOrFail($id);

        $validated = $request->validate([
            'immeuble_id' => 'required|exists:immeuble,id',
            'numero' => 'required|string|max:20',
            'surface' => 'required|numeric|min:1',
            'CIN_A' => 'required|string|max:20',
            'Nom' => 'required|string|max:50',
            'Prenom' => 'required|string|max:50',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            'montant_cotisation_mensuelle' => 'nullable|numeric|min:0',
            'dernier_mois_paye' => 'nullable|date_format:Y-m',
        ]);

        $immeuble = Immeuble::find($request->immeuble_id);
        $cotisation = $request->montant_cotisation_mensuelle ?? $immeuble->cotisation;
        $dernierMoisPaye = $request->dernier_mois_paye
            ? Carbon::createFromFormat('Y-m', $request->dernier_mois_paye)->format('Y-m-d')
            : now()->format('Y-m-d');

        $appartement->update([
            'immeuble_id' => $request->immeuble_id,
            'numero' => $request->numero,
            'surface' => $request->surface,
            'montant_cotisation_mensuelle' => $cotisation,
            'dernier_mois_paye' => $dernierMoisPaye,
            'CIN_A' => $request->CIN_A,
            'Nom' => $request->Nom,
            'Prenom' => $request->Prenom,
            'telephone' => $request->telephone,
            'email' => $request->email,
        ]);

        return redirect()->route('appartements.index')->with('success', 'Appartement mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $appartement = Appartement::findOrFail($id);
        $appartement->delete();

        return redirect()->route('appartements.index')->with('success', 'Appartement supprimé avec succès.');
    }

    public function show($id)
    {
        $appartement = Appartement::findOrFail($id);
        return view('appartements.show', compact('appartement'));
    }
}
