<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Residence;
use App\Models\Immeuble;

class ResidenceController extends Controller
{
    // Afficher toutes les résidences
    public function index()
    {
        $residences = Residence::where('id_S', auth()->id())->get();
        $villes = ['Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger', 'Agadir', 'Meknès', 'Oujda', 'Kenitra', 'Temara'];

        return view('livewire.residences', compact('residences', 'villes'));
    }

    public function create()
    {
        $villes = ['Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger', 'Agadir', 'Meknès', 'Oujda', 'Kenitra', 'Temara'];
        return view('livewire.residences-ajouter', compact('villes'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'nombre_immeubles' => 'required|integer|min:1',
            'ville' => 'required|string|max:100',
            'code_postal' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'cotisation' => 'required|numeric|min:0',
            'caisse' => 'required|numeric|min:0',
        ]);

        $validatedData['id_S'] = auth()->id();

        Residence::create($validatedData);

        return redirect()->back()->with('success', 'Résidence ajoutée avec succès.');
    }

    // Mettre à jour une résidence
    public function update(Request $request, $id)
    {
        $residence = Residence::findOrFail($id);

        $request->validate([
            'nom' => 'required|string|max:255',
            'nombre_immeubles' => 'required|integer|min:1',
            'ville' => 'required|string|max:100',
            'adresse' => 'required|string|max:255',
        ]);

        $residence->update([
            'nom' => $request->nom,
            'nombre_immeubles' => $request->nombre_immeubles,
            'ville' => $request->ville,
            'adresse' => $request->adresse,
        ]);

        return redirect()->back()->with('success', 'Résidence modifiée avec succès.');
    }

    // Supprimer une résidence
    public function destroy($id)
    {
        $residence = Residence::findOrFail($id);
        $residence->delete();

        return redirect()->back()->with('success', 'Résidence supprimée avec succès.');
    }

    // Récupérer les immeubles liés à une résidence
    public function immeublesByResidence($id)
    {
        $immeubles = Immeuble::where('residence_id', $id)->get();

        return response()->json($immeubles);
    }

    public function apiByVille(Request $request)
    {
        $ville = $request->query('ville');
        $residences = Residence::where('ville', $ville)->get();
        return response()->json($residences);
    }
}
