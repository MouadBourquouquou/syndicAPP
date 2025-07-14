<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use App\Models\Paiement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $immeubleIds = $user->immeubles()->pluck('id');
        $appartementIds = \App\Models\Appartement::whereIn('immeuble_id', $immeubleIds)->pluck('id_A');

        $paiements = Paiement::whereIn('id_A', $appartementIds)->paginate(10);

        return view('assistant.paiements.index', compact('paiements'));
    }

    public function facture($id)
    {
        $user = Auth::user();

        $paiement = Paiement::findOrFail($id);

        if (!$user->immeubles->contains('id', $paiement->appartement->immeuble_id)) {
            abort(403);
        }

        return view('assistant.paiements.facture', compact('paiement'));
    }
}
