<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Employe;
use App\Models\Immeuble;
use App\Models\Residence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Notifications\AssistantWelcomeMail;

class EmployeController extends Controller
{
    // 🟩 Affiche la liste des employés
    public function index()
{
    $userId = auth()->id();
    $employes = Employe::with(['immeuble', 'residence'])
    ->where('id_S', $userId)
    ->latest()
    ->paginate(10);
    $residences = Residence::where('id_S', $userId)->get();
    $immeubles = Immeuble::where('id_S', $userId)->get();
    $villes = ['Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger', 'Agadir', 'Meknès', 'Oujda', 'Kenitra', 'Temara'];


    return view('livewire.employes', compact('employes', 'residences', 'immeubles', 'villes'));
}


    public function create()
    {
        $userId = auth()->id();
        $residences = Residence::where('id_S', $userId)->get();
        $immeubles = Immeuble::where('id_S', $userId)->get();
        return view('livewire.employes-ajouter', compact('residences','immeubles'));
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
            'immeuble_id' => 'nullable|exists:immeuble,id',
            'date_embauche' => 'nullable|date',
            'salaire' => 'nullable|numeric|min:0',
        ]);
        $validated['id_S'] = auth()->id();

        $employe = Employe::create($validated);

        if ($validated['poste'] === 'assistant_syndic') {

        // mot de passe aléatoire (ex. 10 caractères)
        $plain = Str::random(10);

        $user = User::create([
            'name'       => $employe->nom,
            'prenom'     => $employe->prenom,
            'email'      => $employe->email,
            'password'   => Hash::make(Str::random(32)), // mot de passe inutilisable
            'statut'     => 'assistant_syndic',
            'is_active'  => 1,
        ]);

        // Envoie automatique du mail avec lien pour choisir un mot de passe
        Password::broker()->sendResetLink(['email' => $user->email]);

    }

        return redirect()->route('livewire.employes')->with('success', 'Employé ajouté');
    }


        public function show($id)
        {
            $employe = Employe::find($id);

            if (!$employe) {
                return redirect()->back()->with('error', 'Employé non trouvé.');
            }

            return view('employes.show', compact('employe'));
        }
        public function update(Request $request, $id_E)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => "required|email|unique:employes,email,$id_E,id_E",
            'telephone' => 'nullable|string|max:20',
            'ville' => 'nullable|string|max:100',
            'adresse' => 'nullable|string|max:256',
            'poste' => 'required|in:assistant_syndic,concierge,femme_menage',
            'residence_id' => 'nullable|exists:residences,id',
            'immeuble_id' => 'nullable|exists:immeuble,id',
            'date_embauche' => 'nullable|date',
            'salaire' => 'nullable|numeric|min:0',
        ]);

        $employe = Employe::findOrFail($id_E);
        $employe->update($validated);

        return redirect()->route('livewire.employes')->with('success', 'Employé mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $employe = Employe::findOrFail($id);
        $employe->delete();

        return redirect()->route('livewire.employes')
                         ->with('success', 'Employé supprimé avec succès.');
    }
    
}
