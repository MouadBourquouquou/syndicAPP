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

    // Enregistre un nouvel employé
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:employes,email',
            'telephone' => 'nullable|string|max:20',
            'ville' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:500',
            'poste' => 'required|string|max:255',
            'immeuble_id' => 'nullable|exists:immeuble,id', // corrigé
            'residence_id' => 'nullable|exists:residences,id',
            'date_embauche' => 'required|date_format:d/m/Y',
            'salaire' => 'nullable|numeric|min:0',
        ]);

        $validated['date_embauche'] = Carbon::createFromFormat('d/m/Y', $validated['date_embauche'])->format('Y-m-d');

        Employe::create($validated);

        return redirect()->route('livewire.employes')->with('success', "L'employé a été ajouté avec succès.");
    }
}
