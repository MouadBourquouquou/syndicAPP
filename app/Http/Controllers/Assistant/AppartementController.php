<?php

namespace App\Http\Controllers\Assistant;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Appartement;
use App\Models\Immeuble;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Employe;

class AppartementController extends Controller
{
   public function index()
{
    $user = auth()->user();
    $employe = Employe::where('email', $user->email)->first();

    if (!$employe) {
        abort(403, 'Aucun employé trouvé avec cet email.');
    }

    $immeubleIds = DB::table('employe_immeuble')
        ->where('employe_id', $employe->id_E) 
        ->pluck('immeuble_id');                 

    $appartementIds = Appartement::whereIn('immeuble_id', $immeubleIds)
        ->pluck('id_A');
    $immeubles = Immeuble::whereIn('id', $immeubleIds)->get();

    $appartements = Appartement::whereIn('id_A', $appartementIds)->get();

    return view('livewire.appartements', compact('appartements', 'immeubles'));
}



    public function show($id)
    {
        $userId = auth()->id();

        // Récupérer les immeubles liés à l'employé
        $immeubleIds = \DB::table('employe_immeuble')
            ->where('employe_id', $userId)
            ->pluck('immeuble_id');

        // Récupérer l'appartement seulement s'il appartient à un immeuble de la liste
        $appartement = Appartement::where('id', $id)
            ->whereIn('immeuble_id', $immeubleIds)
            ->with('immeuble')
            ->first();

        if (!$appartement) {
            // Pas trouvé ou pas autorisé à voir cet appartement
            return redirect()->route('appartements.index')->with('error', 'Appartement non trouvé ou accès refusé.');
        }

        return view('appartements.show', compact('appartement'));
    }

}
