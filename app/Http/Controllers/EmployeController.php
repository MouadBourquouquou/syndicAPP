<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Immeuble;
use App\Models\Residence;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmployeController extends Controller
{
    // Affiche la liste des employés
    public function index()
{
    // Remplacer get() par paginate(10) pour paginer par 10 éléments
    $employes = Employe::with(['immeuble', 'residence'])->latest()->paginate(10);
    return view('livewire.employes', compact('employes'));
}


    // Affiche le formulaire d'ajout d'un employé
    public function create()
    {
        $immeubles = Immeuble::all();
        $residences = Residence::all();
        return view('livewire.employes-ajouter', compact('immeubles', 'residences'));
    }




public function store(Request $request)
{
    $validated = $request->validate([
        'nom' => 'required|string|max:100',
        'prenom' => 'required|string|max:100',
        'email' => 'required|email|unique:employes,email',
        'telephone' => 'nullable|string|max:20',
        'ville' => 'nullable|string|max:100',
        'adresse' => 'nullable|string|max:256',
        'poste' => 'required|in:assistant_syndic,concierge,femme_menage',
        'residence_id' => 'nullable|exists:residences,id',
        'immeubles' => 'nullable|array',
        'immeubles.*' => 'exists:immeuble,id',
        'date_embauche' => 'required|date',
        'salaire' => 'nullable|numeric|min:0',
    ]);

    $employe = Employe::create([
        'nom' => $validated['nom'],
        'prenom' => $validated['prenom'],
        'email' => $validated['email'],
        'telephone' => $validated['telephone'] ?? null,
        'ville' => $validated['ville'] ?? null,
        'adresse' => $validated['adresse'] ?? null,
        'poste' => $validated['poste'],
        'residence_id' => $validated['residence_id'] ?? null,
        'date_embauche' => $validated['date_embauche'],
        'salaire' => $validated['salaire'] ?? 0,
    ]);

    // Synchronisation des immeubles liés via la table pivot
    if (!empty($validated['immeubles'])) {
        $employe->immeubles()->sync($validated['immeubles']);
    } else {
        $employe->immeubles()->sync([]);
    }

   
        return redirect()->route('livewire.employes-ajouter')->with('success', "L'employé a été ajouté avec succès.");
    }

}