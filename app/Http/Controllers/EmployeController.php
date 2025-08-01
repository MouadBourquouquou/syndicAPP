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
use App\Traits\NotifiesUsersOfActions;

class EmployeController extends Controller
{
    use NotifiesUsersOfActions;
    public function index()
{
    $userId = auth()->id();
    $employes = Employe::with(['immeubles.residence'])
        ->where('id_S', $userId)
        ->latest()
        ->paginate(10);

    // Pour chaque employé, créer une collection de résidences uniques liées à ses immeubles
    foreach ($employes as $employe) {
        $employe->residences = $employe->immeubles
            ->map(fn($immeuble) => $immeuble->residence)
            ->filter() // enlève les null (immeubles sans résidence)
            ->unique('id') // résidences uniques
            ->values(); // reset des clés
    }

    $residences = Residence::where('id_S', $userId)->get();
    $immeubles = Immeuble::where('id_S', $userId)->get();
    $villes = ['Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger', 'Agadir', 'Meknès', 'Oujda', 'Kenitra', 'Temara'];

    return view('livewire.employes', compact('employes', 'residences', 'immeubles', 'villes'));
}



    public function create()
    {
        $userId = auth()->id();
        $residences = Residence::where('id_S', $userId)->get();
        $immeubles = Immeuble::with('residence')->where('id_S', $userId)->get();
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
        'date_embauche' => 'nullable|date',
        'salaire' => 'nullable|numeric|min:0',
        'immeubles' => 'nullable|array',            // <-- Ajout
        'immeubles.*' => 'exists:immeuble,id',    // <-- Ajout, vérifie que chaque immeuble existe
    ]);
    $validated['id_S'] = auth()->id();

    $employe = Employe::create($validated);

    if ($request->has('immeubles')) {
        // Attache les immeubles sélectionnés
        $employe->immeubles()->attach($request->input('immeubles'));
    }

    if ($validated['poste'] === 'assistant_syndic') {
        $plain = Str::random(10);

        $user = User::create([
            'id'         => $employe->id_E,
            'name'       => $employe->nom,
            'prenom'     => $employe->prenom,
            'email'      => $employe->email,
            'password'   => Hash::make(Str::random(32)),
            'statut'     => 'assistant_syndic',
            'is_active'  => 1,
        ]);

        Password::broker()->sendResetLink(['email' => $user->email]);
    }
    $this->notifyUser(' a ajouté', $employe, ' un Employé', [], 'employe');

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
                'date_embauche' => 'nullable|date',
                'salaire' => 'nullable|numeric|min:0',
                'immeubles' => 'nullable|array',            // Ajout
                'immeubles.*' => 'exists:immeuble,id',    // Ajout
            ]);

            $employe = Employe::findOrFail($id_E);
            $employe->update($validated);

            if ($request->has('immeubles')) {
                // Mets à jour les immeubles liés (sync remplace les anciens)
                $employe->immeubles()->sync($request->input('immeubles'));
            } else {
                // Si aucun immeuble sélectionné, détache tous
                $employe->immeubles()->detach();
            }
            $this->notifyUser(' a mis à jour', $employe, ' un Employé', [], 'employe');
            return redirect()->route('livewire.employes')->with('success', 'Employé mis à jour avec succès.');
        }


    public function destroy($id)
    {
        $employe = Employe::findOrFail($id);
        $user = User::where('email', $employe->email)->first();
        $employe->delete();
        if ($user) {
            $user->delete();
            $this->notifyUser(' a supprimé', $user, ' un Employé', [], 'employe');
        }


        return redirect()->route('livewire.employes')
                         ->with('success', 'Employé supprimé avec succès.');
    }
    
}
