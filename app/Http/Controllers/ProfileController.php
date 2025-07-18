<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        return view('livewire.profile', [
            'user' => Auth::user(),
        ]);
    }

public function update(Request $request)
{
    $user = Auth::user();

    $validated = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email,' . $user->id,
        'phone'    => 'nullable|string|max:20',
        'address'  => 'nullable|string|max:500',
        'file'     => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        'current_password' => 'nullable|required_with:password',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    // Si un nouveau mot de passe est soumis
    if ($request->filled('password')) {
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Mot de passe actuel incorrect.']);
        }

        $user->password = Hash::make($request->input('password'));
    }

    $user->name     = $request->input('name');
    $user->email    = $request->input('email');
    $user->tel      = $request->input('phone');
    $user->adresse  = $request->input('address');

    if ($request->hasFile('file')) {
        $file = $request->file('file');

        if ($user->logo && file_exists(public_path($user->logo))) {
            unlink(public_path($user->logo));
        }

        $hashedName = sha1_file($file->getRealPath()) . '.' . $file->getClientOriginalExtension();
        $destination = 'uploads/logos';
        $file->move(public_path($destination), $hashedName);

        $user->logo = $destination . '/' . $hashedName;
    }

    $user->save();

    return redirect()->back()->with('success', 'Profil mis à jour avec succès !');
}


}
