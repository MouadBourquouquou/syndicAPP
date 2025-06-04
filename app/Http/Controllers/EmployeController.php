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
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|email|unique:employes,email',
        'telephone' => 'nullable|string|max:20',
        'ville' => 'required|string',
        'adresse' => 'nullable|string',
        'poste' => 'required|string',
        'residence_id' => 'required|exists:residences,id',
        'immeuble_id' => 'nullable|exists:immeuble,id', // Notez le nom de table 'immeuble' au singulier
        'date_embauche' => 'required|date_format:d/m/Y',
        'salaire' => 'nullable|numeric|min:0',
    ]);

    // Convertir la date au format MySQL
    $date_embauche = \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_embauche)->format('Y-m-d');

    

        return redirect()->route('livewire.employes-ajouter')->with('success', "L'employé a été ajouté avec succès.");
    }

}