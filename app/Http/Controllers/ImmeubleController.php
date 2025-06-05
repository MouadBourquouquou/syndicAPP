<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Immeuble;
use App\Models\Residence;

class ImmeubleController extends Controller
{
    public function index()
    {
        $immeubles = Immeuble::withCount('appartements')->get();
        $residences = Residence::all();

        return view('livewire.immeubles', compact('immeubles', 'residences'));
    }


    public function create()
    {
        $residences = Residence::all();
        $villes = ['Casablanca', 'Rabat', 'Marrakech'];

        return view('livewire.immeubles-ajouter', compact('residences', 'villes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'nombre_app' => 'required|integer',
            'a_residence' => 'required|in:oui,non',
        ]);

        $immeubleData = [
            'nom' => $validated['nom'],
            'nombre_app' => $validated['nombre_app'],
        ];

        if ($request->a_residence === 'oui') {
            $request->validate([
                'residence_id' => 'required|exists:residences,id',
            ]);

            $residence = Residence::find($request->residence_id);

            $immeubleData = array_merge($immeubleData, [
                'ville' => $residence->ville,
                'code_postal' => $residence->code_postal,
                'adresse' => $residence->adresse,
                'cotisation' => $residence->cotisation,
                'caisse' => $residence->caisse,
                'residence_id' => $request->residence_id,
            ]);
        } else {
            $request->validate([
                'ville' => 'required|string|max:255',
                'code_postal' => 'required|numeric',
                'adresse' => 'required|string|max:255',
                'cotisation' => 'required|numeric',
                'caisse' => 'required|numeric',
            ]);

            $immeubleData = array_merge($immeubleData, [
                'ville' => $request->ville,
                'code_postal' => $request->code_postal,
                'adresse' => $request->adresse,
                'cotisation' => $request->cotisation,
                'caisse' => $request->caisse,
                'residence_id' => null,
            ]);
        }

        Immeuble::create($immeubleData);

        return redirect()->route('livewire.immeubles-ajouter')->with('success', 'Immeuble ajouté avec succès.');
    }

    public function show($id)
    {
        $immeuble = Immeuble::with('appartements', 'residence')->findOrFail($id);
        return view('immeubles.show', compact('immeuble'));
    }

    public function edit($id)
    {
        $immeuble = Immeuble::findOrFail($id);
        $residences = Residence::all();
        $villes = ['Casablanca', 'Rabat', 'Marrakech'];

        return view('livewire.immeubles-edit', compact('immeuble', 'residences', 'villes'));
    }

    public function update(Request $request, $id)
    {
        $immeuble = Immeuble::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'nombre_app' => 'required|integer',
            'a_residence' => 'required|in:oui,non',
        ]);

        $immeubleData = [
            'nom' => $validated['nom'],
            'nombre_app' => $validated['nombre_app'],
        ];

        if ($request->a_residence === 'oui') {
            $request->validate([
                'residence_id' => 'required|exists:residences,id',
            ]);

            $residence = Residence::find($request->residence_id);

            $immeubleData = array_merge($immeubleData, [
                'ville' => $residence->ville,
                'code_postal' => $residence->code_postal,
                'adresse' => $residence->adresse,
                'cotisation' => $residence->cotisation,
                'caisse' => $residence->caisse,
                'residence_id' => $request->residence_id,
            ]);
        } else {
            $request->validate([
                'ville' => 'required|string|max:255',
                'code_postal' => 'required|numeric',
                'adresse' => 'required|string|max:255',
                'cotisation' => 'required|numeric',
                'caisse' => 'required|numeric',
            ]);

            $immeubleData = array_merge($immeubleData, [
                'ville' => $request->ville,
                'code_postal' => $request->code_postal,
                'adresse' => $request->adresse,
                'cotisation' => $request->cotisation,
                'caisse' => $request->caisse,
                'residence_id' => null,
            ]);
        }

        $immeuble->update($immeubleData);

        return redirect()->route('immeubles.index')->with('success', 'Immeuble modifié avec succès.');
    }

    public function destroy($id)
    {
        $immeuble = Immeuble::findOrFail($id);
        $immeuble->delete();

        return redirect()->route('immeubles.index')->with('success', 'Immeuble supprimé avec succès.');
    }

    public function getInfo($id)
    {
        $residence = Residence::findOrFail($id);
        return response()->json([
            'ville' => $residence->ville,
            'code_postal' => $residence->code_postal,
            'adresse' => $residence->adresse,
            'cotisation' => $residence->cotisation,
            'caisse' => $residence->caisse,
        ]);
    }

    public function getCotisation($id)
    {
        $immeuble = Immeuble::findOrFail($id);
        return response()->json([
            'cotisation' => $immeuble->cotisation
        ]);
    }
}
