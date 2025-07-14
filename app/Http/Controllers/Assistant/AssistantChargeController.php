<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use App\Models\Charge;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChargeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $immeubleIds = $user->immeubles()->pluck('id');

        $charges = Charge::whereIn('immeuble_id', $immeubleIds)->paginate(10);

        return view('assistant.charges.index', compact('charges'));
    }

    public function show($id)
    {
        $user = Auth::user();

        $charge = Charge::findOrFail($id);

        // Check access permission
        if (!$user->immeubles->contains('id', $charge->immeuble_id)) {
            abort(403);
        }

        return view('assistant.charges.show', compact('charge'));
    }
}
