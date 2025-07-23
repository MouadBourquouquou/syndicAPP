<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Immeuble;
use App\Models\Residence;
use App\Traits\NotifiesUsersOfActions;

class ImmeubleController extends Controller
{
    use NotifiesUsersOfActions;
    public function index()
    {        
    $userId = auth()->id();
        $immeubles = Immeuble::withCount('appartements')
                    ->where('id_S', $userId)
                    ->get();
        $residences = Residence::where('id_S', $userId)->get();
        $villes = ['Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger', 'Agadir', 'Meknès', 'Oujda', 'Kenitra', 'Temara'];

        return view('livewire.immeubles', compact('immeubles', 'residences','villes'));
    }

    public function create()
    {
        $userId = auth()->id();
        $residences = Residence::where('id_S', $userId)->get();
        if ($residences->isEmpty()) {
            return redirect()->route('residences.create')
                             ->with('error', 'Veuillez d\'abord créer une résidence.');
        }
        $villes =$villeList = ['Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger', 'Agadir', 'Meknès', 'Oujda', 'Kenitra', 'Temara'];

        return view('livewire.immeubles-ajouter', compact('residences', 'villes'));
    }

    public function store(Request $request)
    {
        $immeubleData = $this->prepareImmeubleData($request);
        $userId = auth()->id();
        $immeubleData['id_S'] = $userId;
        $immeuble=Immeuble::create($immeubleData);

        $this->notifyUser(' a ajouté', $immeuble, ' un Immeuble');

        return redirect()->route('immeubles-ajouter')
                         ->with('success', 'Immeuble ajouté avec succès.');
    }

    public function show($id)
    {
        $immeuble = Immeuble::with('appartements', 'residence')->findOrFail($id);
        return view('immeubles.show', compact('immeuble'));
    }

    public function edit($id)
    {
        $immeuble = Immeuble::findOrFail($id);
        $residences = Residence::where('id_S', auth()->id())->get();
        $villes = ['Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger', 'Agadir', 'Meknès', 'Oujda', 'Kenitra', 'Temara'];
        if ($residences->isEmpty()) {
            return redirect()->route('residences.create')
                             ->with('error', 'Veuillez d\'abord créer une résidence.');
        }
        return view('livewire.immeubles-edit', compact('immeuble', 'residences', 'villes'));
    }

    public function update(Request $request, $id)
    {
        
{
    $immeuble = Immeuble::findOrFail($id);

    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'residence_id' => 'required|exists:residences,id',
        'ville' => 'required|string|max:255',
        'adresse' => 'required|string|max:255',
        'cotisation' => 'nullable|numeric',
        'caisse' => 'nullable|numeric',

    ]);

    $immeuble->update($validated);
    $this->notifyUser(' a mis à jour', $immeuble, ' un Immeuble');

    return redirect()->route('immeubles.index')->with('success', 'Immeuble modifié avec succès.');
}

    }

    public function destroy($id)
    {
        $immeuble = Immeuble::findOrFail($id);
        $immeuble->delete();
        $this->notifyUser(' a supprimé', $immeuble, ' un Immeuble');

        return redirect()->route('immeubles.index')
                         ->with('success', 'Immeuble supprimé avec succès.');
    }

    public function getInfo($id)
    {
        $residence = Residence::findOrFail($id);
        return response()->json([
            'ville' => $residence->ville,
            'code_postal' => $residence->code_postal,
            'adresse' => $residence->adresse,
            'cotisation' => $residence->cotisation,
            'caisse' => $residence->caisse,
        ]);
    }

    public function apiByResidence($residenceId)
    {
        $immeubles = Immeuble::where('residence_id', $residenceId)
            ->where('id_S', auth()->id())
            ->get();

        return response()->json($immeubles);
    }



    public function getCotisation($id)
    {
        $immeuble = Immeuble::findOrFail($id);
        return response()->json([
            'cotisation' => $immeuble->cotisation
        ]);
    }

    /**
     * Prépare les données validées d’un immeuble, selon s’il appartient à une résidence ou non.
     */
    private function prepareImmeubleData(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'nombre_app' => 'required|integer',
            'a_residence' => 'required|in:oui,non',
        ]);

        $immeubleData = [
            'nom' => $validated['nom'],
            'nombre_app' => $validated['nombre_app'],
        ];

        if ($request->a_residence === 'oui') {
            $request->validate([
                'residence_id' => 'required|exists:residences,id',
            ]);

            $residence = Residence::findOrFail($request->residence_id);

            return array_merge($immeubleData, [
                'ville' => $residence->ville,
                'code_postal' => $residence->code_postal,
                'adresse' => $residence->adresse,
                'cotisation' => $residence->cotisation,
                'caisse' => $residence->caisse,
                'residence_id' => $residence->id,
            ]);
        } else {
            $request->validate([
                'ville' => 'required|string|max:255',
                'code_postal' => 'required|numeric',
                'adresse' => 'required|string|max:255',
                'cotisation' => 'required|numeric',
                'caisse' => 'required|numeric',
            ]);

            return array_merge($immeubleData, [
                'ville' => $request->ville,
                'code_postal' => $request->code_postal,
                'adresse' => $request->adresse,
                'cotisation' => $request->cotisation,
                'caisse' => $request->caisse,
                'residence_id' => null,
            ]);
        }
    }
    public function apiIndex(Request $request)
    {
        $query = Immeuble::with('residence')->where('ville', $request->ville);

        if ($request->has('residence_id')) {
            $query->where('residence_id', $request->residence_id);
        } elseif ($request->has('no_residence')) {
            // afficher seulement immeubles sans résidence (residence_id = null)
            $query->whereNull('residence_id');
        }

        return response()->json($query->get());
    }



}
