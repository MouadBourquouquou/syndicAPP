<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appartement;
use App\Models\Immeuble;
use Illuminate\Support\Carbon;
class AppartementController extends Controller
{
    // Affiche le formulaire d'ajout d'appartement
    public function create()
    {
        $immeubles = Immeuble::all();
        return view('livewire.appartements-ajouter', ['immeubles' => $immeubles]);
    }

    // Enregistre un nouvel appartement en base
   public function store(Request $request)
{
    $validated = $request->validate([
        'immeuble_id' => 'required|exists:immeuble,id', // Changé de immeubles à immeuble
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

    // Récupérer l'immeuble
    $immeuble = Immeuble::find($request->immeuble_id); // Le modèle reste Immeuble (singulier)

    // Déterminer le montant de cotisation
    $cotisation = $request->montant_cotisation_mensuelle ?? $immeuble->cotisation;

    // Déterminer le dernier mois payé
   $dernierMoisPaye = $request->dernier_mois_paye 
    ? Carbon::createFromFormat('Y-m', $request->dernier_mois_paye)->format('Y-m-d')
    : now()->format('Y-m-d');


    // Créer l'appartement
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

    return redirect()->route('appartements.ajouter')->with('success', 'Appartement ajouté avec succès.');
}   
    public function index()
    {
        $appartements = Appartement::with('immeuble')->paginate(10);
        return view('livewire.appartements', compact('appartements'));
    }
}