<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Assuming 'User' is your Syndic model
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    // Affiche le formulaire
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Traite le formulaire
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'statut' => 'required|in:professionnel,benevolat',
            'nom_societe' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'adresse' => 'required|string|max:255',
            'tel' => 'required|string|max:20',
            // 'Fax' dans votre liste d'attributs est souvent un champ de type string et est généralement facultatif.
            // Si vous voulez qu'il soit obligatoire, changez 'nullable' en 'required'.
            'Fax' => 'nullable|string|max:20', // <--- AJOUTÉ : Validation pour le champ Fax
            'ville' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Création de l'utilisateur (Syndic)
        User::create([
            'statut' => $request->input('statut'),
            'nom_societé' => $request->input('nom_societe'), // Assurez-vous que le nom de la colonne dans votre DB est bien 'nom_societé'
            'name' => $request->input('name'),
            'prenom' => $request->input('prenom'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'adresse' => $request->input('adresse'),
            'tel' => $request->input('tel'),
            'Fax' => $request->input('Fax'), // <--- AJOUTÉ : Assignation du champ Fax
            'ville' => $request->input('ville'),
        ]);

        return redirect()->route('login')->with('success', 'Compte créé avec succès !');
    }
}