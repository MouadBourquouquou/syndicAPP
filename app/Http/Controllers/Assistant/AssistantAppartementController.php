<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use App\Models\Appartement;
use Illuminate\Support\Facades\Auth;

class AppartementController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $immeubleIds = $user->immeubles()->pluck('id');

        $appartements = Appartement::whereIn('immeuble_id', $immeubleIds)->paginate(10);

        return view('assistant.appartements.index', compact('appartements'));
    }

    public function show($id)
    {
        $user = Auth::user();

        $appartement = Appartement::findOrFail($id);

        if (!$user->immeubles->contains('id', $appartement->immeuble_id)) {
            abort(403);
        }

        return view('assistant.appartements.show', compact('appartement'));
    }
}
