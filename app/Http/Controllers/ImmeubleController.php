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
        // Récupérer tous les immeubles avec leur résidence et le nombre d'appartements
        $immeubles = Immeuble::with('residence')
            ->withCount('appartements')
            ->get();

        return view('livewire.immeubles', compact('immeubles'));
    }

    /**
     * Affiche le formulaire d'ajout d'un immeuble.
     */
    public function create()
    {
        // Charger toutes les résidences
        $residences = Residence::all();

        // Liste de villes (peut être rendue dynamique plus tard)
        $villes = ['Casablanca', 'Rabat', 'Marrakech'];

        return view('livewire.immeubles-ajouter', compact('residences', 'villes'));
    }

    /**
     * Enregistre un nouvel immeuble.
     */
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

        // Récupérer les infos de la résidence
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
