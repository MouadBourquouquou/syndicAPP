<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appartement;
use App\Models\Immeuble;

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
        $messages = [
            'CIN_A.required' => 'Le champ CIN est obligatoire.',
            'CIN_A.string' => 'Le CIN doit être une chaîne de caractères.',
            'CIN_A.max' => 'Le CIN ne peut pas dépasser 10 caractères.',
            'CIN_A.min' => 'Le CIN doit contenir au moins 6 caractères.',
            'Nom.required' => 'Le nom est obligatoire.',
            'Nom.string' => 'Le nom doit être une chaîne de caractères.',
            'Nom.max' => 'Le nom ne peut pas dépasser 100 caractères.',
            'Prenom.required' => 'Le prénom est obligatoire.',
            'Prenom.string' => 'Le prénom doit être une chaîne de caractères.',
            'Prenom.max' => 'Le prénom ne peut pas dépasser 100 caractères.',
            'immeuble_id.required' => 'L\'immeuble est obligatoire.',
            'immeuble_id.exists' => 'L\'immeuble sélectionné est invalide.',
            'numero.required' => 'Le numéro de porte est obligatoire.',
            'numero.string' => 'Le numéro de porte doit être une chaîne.',
            'numero.max' => 'Le numéro de porte est trop long.',
            'surface.required' => 'La surface est obligatoire.',
            'surface.numeric' => 'La surface doit être un nombre.',
            'surface.min' => 'La surface doit être positive.',
            'montant_cotisation_mensuelle.required' => 'Le montant de cotisation est obligatoire.',
            'montant_cotisation_mensuelle.numeric' => 'Le montant doit être un nombre.',
            'montant_cotisation_mensuelle.min' => 'Le montant ne peut pas être négatif.',
            'dernier_mois_paye.required' => 'Le dernier mois payé est obligatoire.',
            'dernier_mois_paye.date_format' => 'Le format du dernier mois payé doit être YYYY-MM.',
            'telephone.required' => 'Le téléphone est obligatoire.',
            'telephone.regex' => 'Le format du téléphone est invalide. Exemple : +212 6 12 34 56 78',
        ];

        $validatedData = $request->validate([
            'CIN_A' => 'required|string|min:6|max:10',
            'Nom' => 'required|string|max:100',
            'Prenom' => 'required|string|max:100',
            'immeuble_id' => 'required|exists:immeuble,id',
            'numero' => 'required|string|max:50',
            'surface' => 'required|numeric|min:0.1',
            'montant_cotisation_mensuelle' => 'required|numeric|min:0',
            'dernier_mois_paye' => 'required|date_format:Y-m',
            'telephone' => ['required', 'regex:/^\+212\s?\d{1}\s?\d{2}\s?\d{2}\s?\d{2}\s?\d{2}$/'],
        ], $messages);

        $dernierMoisPaye = $validatedData['dernier_mois_paye'] . '-01';

        Appartement::create([
            'CIN_A' => $validatedData['CIN_A'],
            'Nom' => $validatedData['Nom'],
            'Prenom' => $validatedData['Prenom'],
            'immeuble_id' => $validatedData['immeuble_id'],
            'numero' => $validatedData['numero'],
            'surface' => $validatedData['surface'],
            'montant_cotisation_mensuelle' => $validatedData['montant_cotisation_mensuelle'],
            'dernier_mois_paye' => $dernierMoisPaye,
            'telephone' => $validatedData['telephone'],
        ]);

        return redirect()->route('appartement.create')->with('success', 'Appartement ajouté avec succès.');
    }

    // Liste paginée des appartements avec immeubles associés
    public function index()
    {
        $appartements = Appartement::with('immeuble')->paginate(10);
        return view('livewire.appartements', compact('appartements'));
    }
}
