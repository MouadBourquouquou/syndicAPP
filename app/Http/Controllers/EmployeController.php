<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Immeuble;
use Illuminate\Http\Request;

class EmployeController extends Controller
{
    // Afficher la liste des employés (facultatif si tu en as besoin)
    public function index()
    {
        $employes = Employe::with('immeuble')->latest()->get();
        return view('employes.index', compact('employes'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        $immeubles = Immeuble::all(); // pour alimenter la liste déroulante
        return view('employes.create', compact('immeubles'));
    }

    // Enregistrer un nouvel employé
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:employes,email',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:500',
            'date_naissance' => 'nullable|date_format:d/m/Y',
            'poste' => 'required|string|max:255',
            'immeuble_id' => 'required|exists:immeubles,id',
            'date_embauche' => 'required|date_format:d/m/Y',
            'salaire' => 'nullable|numeric|min:0',
        ]);

        // Convertir les dates au format Y-m-d
        $validated['date_naissance'] = $validated['date_naissance'] 
            ? \Carbon\Carbon::createFromFormat('d/m/Y', $validated['date_naissance'])->format('Y-m-d') 
            : null;

        $validated['date_embauche'] = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['date_embauche'])->format('Y-m-d');

        Employe::create($validated);

        return redirect()->route('employe.index')->with('success', "L'employé a été ajouté avec succès.");
    }
}
