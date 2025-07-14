<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use App\Models\Immeuble;
use Illuminate\Support\Facades\Auth;

class ImmeubleController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $immeubles = $user->immeubles()->paginate(10);

        return view('assistant.immeubles.index', compact('immeubles'));
    }

    public function show($id)
    {
        $user = Auth::user();

        $immeuble = Immeuble::findOrFail($id);

        if (!$user->immeubles->contains('id', $immeuble->id)) {
            abort(403);
        }

        return view('assistant.immeubles.show', compact('immeuble'));
    }
}
