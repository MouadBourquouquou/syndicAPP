<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Residence;
use App\Models\Immeuble;
use App\Models\Employe;
use Illuminate\Support\Facades\DB;

class ResidenceController extends Controller
{
    /**
     * Afficher les résidences associées aux immeubles liés à l'employé connecté.
     */
    public function index()
    {
        $user = auth()->user();

        // Trouver l'employé correspondant via l'email
        $employe = Employe::where('email', $user->email)->first();

        if (!$employe) {
            return redirect()->back()->with('error', 'Aucun employé lié à cet utilisateur.');
        }

        // Récupérer les ID des immeubles liés à cet employé
        $immeubleIds = DB::table('employe_immeuble')
            ->where('employe_id', $employe->id_E)
            ->pluck('immeuble_id');

        // Récupérer les IDs des résidences liées à ces immeubles
        $residenceIds = Immeuble::whereIn('id', $immeubleIds)
            ->pluck('residence_id')
            ->unique();

        // Récupérer les résidences finales
        $residences = Residence::whereIn('id', $residenceIds)->get();
        $villes = Residence::distinct()->pluck('ville')->filter()->values();


        return view('livewire.residences', compact('residences', 'villes'));
    }
}
