<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
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
            'name' => 'required|string|max:255',          // <-- modifié ici
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'adresse' => 'required|string|max:255',
            'tel' => 'required|string|max:20',
            'ville' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Création de l'utilisateur
        User::create([
            'statut' => $request->input('statut'),
            'name' => $request->input('name'),             // <-- modifié ici
            'prenom' => $request->input('prenom'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'adresse' => $request->input('adresse'),
            'tel' => $request->input('tel'),
            'ville' => $request->input('ville'),
        ]);

        return redirect()->route('login')->with('success', 'Compte créé avec succès !');
    }
}
