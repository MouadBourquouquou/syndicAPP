<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Immeuble;
use App\Models\Residence;

class ImmeubleController extends Controller
{
    /**
     * Affiche la liste des immeubles.
     */
    public function index()
{
    // Récupérer tous les immeubles avec la résidence liée et le nombre d'appartements
    $immeubles = Immeuble::with('residence')
        ->withCount('appartements')
        ->get();

    // Passer la variable au pluriel
    return view('livewire.immeubles', compact('immeubles'));
}


    /**
     * Affiche le formulaire d'ajout d'un immeuble.
     */
    public function create()
    {
        $residences = Residence::all();

        // Liste des villes (à adapter ou récupérer dynamiquement)
        $villes = ['Casablanca', 'Rabat', 'Marrakech'];

        return view('livewire.immeubles-ajouter', compact('residences', 'villes'));
    }

    /**
     * Enregistre un nouvel immeuble.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'a_residence' => 'required|in:oui,non',
            'residence_id' => 'nullable|exists:residences,id',
            'nom' => 'required|string|max:255',
            'ville' => 'required_if:a_residence,non|string|max:255',
            'code_postal' => 'required_if:a_residence,non|numeric|digits_between:4,10',
            'adresse' => 'required_if:a_residence,non|string|max:255',
            'nombre_app' => 'required|integer|min:0',
            'cotisation' => 'required|numeric|min:0',
            'caisse' => 'required_if:a_residence,non|numeric|min:0',
        ]);

        // Préparation des données à insérer
        $data = [
            'nom' => $validated['nom'],
            'cotisation' => $validated['cotisation'],
            'nombre_app' => $validated['nombre_app'],
        ];

        if ($validated['a_residence'] === 'oui') {
            $data['residence_id'] = $validated['residence_id'] ?? null;

            // Si l'immeuble appartient à une résidence, on ne stocke pas ville, code_postal, adresse, caisse
            $data['ville'] = null;
            $data['code_postal'] = null;
            $data['adresse'] = null;
            $data['caisse'] = null;
        } else {
            // Si pas de résidence, on stocke ces champs
            $data['ville'] = $validated['ville'];
            $data['code_postal'] = $validated['code_postal'];
            $data['adresse'] = $validated['adresse'];
            $data['caisse'] = $validated['caisse'];
            $data['residence_id'] = null;
        }

        Immeuble::create($data);

        return redirect()->back()->with('success', 'Immeuble ajouté avec succès.');
    }
}
