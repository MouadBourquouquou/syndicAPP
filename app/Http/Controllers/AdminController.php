<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Immeuble;
use App\Models\Residence;
use Illuminate\Http\Request;
use App\Notifications\UserActivated;
use App\Notifications\UserRejected;
use App\Notifications\SyndicDeactivated;



class AdminController extends Controller
{
    public function index()
    {
        $nbSyndics = User::where('is_admin', 0)
            ->where('is_active', 1)
            ->count();
        $nbAdmins = User::where('is_admin', 1)->count();
        $nbImmeubles = Immeuble::count();
        $nbResidences = Residence::count();

        // Compter les appartements et employés si tu as leurs modèles
        $nbAppartements = \App\Models\Appartement::count();
        $nbEmployes = \App\Models\Employe::count();

        return view('admin.dashboard', compact(
            'nbSyndics',
            'nbAdmins',
            'nbImmeubles',
            'nbResidences',
            'nbAppartements',
            'nbEmployes'
        ));
    }

    public function listDemandes()
    {
        $demandes = User::where('is_pending', 1)
            ->where('is_admin', 0)
            ->where('is_active', 0)
            ->get();

        return view('admin.demandes', compact('demandes'));
    }


    public function activerDemande($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = 1;
        $user->email_verified_at = now();
        $user->save();

        $user->notify(new UserActivated($user->email, $user->password));

        return redirect()->route('admin.demandes')->with('success', 'Demande activée, le syndic peut maintenant se connecter.');
    }


    public function refuserDemande(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->notify(new UserRejected($request->input('reason')));
        Immeuble::where('id_S', $user->id)->delete();
        Residence::where('id_S', $user->id)->delete();
        $user->delete();

        return redirect()->route('admin.demandes')->with('success', 'Demande refusée et supprimée.');
    }



    public function listSyndics()
    {
        $syndics = \App\Models\User::where('is_admin', 0)
            ->where('is_active', 1)
            ->paginate(10);
        return view('admin.syndics', compact('syndics'));
    }


    public function disableSyndic($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'is_active' => 0,
            'is_pending' => 0
        ]);


        // Envoi de la notification
        $user->notify(new SyndicDeactivated());

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Syndic désactivé et notifié.');
    }
    public function showSyndic($id)
    {
        $syndic = User::findOrFail($id);

        $residences = Residence::where('id_S', $syndic->id)->get();

        $immeubles = Immeuble::where('id_S', $syndic->id)
            ->with('residence') // pour afficher la résidence liée
            ->get();

        return view('admin.syndic-detail', compact('syndic', 'residences', 'immeubles'));
    }

    public function listeAdmins()
    {
        $admins = User::where('is_admin', 1)->get();
        return view('admin.admins.index', compact('admins'));
    }

    public function createAdmin()
    {
        return view('admin.admins.create');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => 1,
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Administrateur ajouté avec succès.');
    }

    public function destroyAdmin($id)
    {
        $admin = User::findOrFail($id);

        if ($admin->is_admin != 1) {
            return back()->with('error', 'Ce n’est pas un administrateur.');
        }

        $admin->delete();
        return back()->with('success', 'Administrateur supprimé.');
    }
}
