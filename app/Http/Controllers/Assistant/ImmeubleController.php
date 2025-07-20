<?php

namespace App\Http\Controllers\Assistant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Immeuble;
use App\Models\Residence;

class ImmeubleController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Immeubles liés à l'employé connecté
        $immeubles = Immeuble::withCount('appartements')
            ->whereHas('employes', function($query) use ($userId) {
                $query->where('employe_id', $userId);
            })
            ->get();

        $residences = Residence::where('id_S', $userId)->get();
        $villes = ['Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger', 'Agadir', 'Meknès', 'Oujda', 'Kenitra', 'Temara'];

        return view('livewire.immeubles', compact('immeubles', 'residences', 'villes'));
    }

    public function show($id)
    {
        $userId = auth()->id();

        // Sécuriser l'accès à l'immeuble
        $immeuble = Immeuble::with('appartements', 'residence')
            ->whereHas('employes', function($query) use ($userId) {
                $query->where('employe_id', $userId);
            })
            ->findOrFail($id);

        return view('immeubles.show', compact('immeuble'));
    }

    public function getInfo($id)
    {
        $userId = auth()->id();

        // Vérifier que la résidence appartient à l'utilisateur
        $residence = Residence::where('id_S', $userId)->findOrFail($id);

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
        $userId = auth()->id();

        // Immeubles de la résidence, liés à l'utilisateur
        $immeubles = Immeuble::where('residence_id', $residenceId)
            ->whereHas('employes', function($query) use ($userId) {
                $query->where('employe_id', $userId);
            })
            ->get();

        return response()->json($immeubles);
    }

    public function getCotisation($id)
    {
        $userId = auth()->id();

        // Immeuble lié à l'employé connecté
        $immeuble = Immeuble::whereHas('employes', function($query) use ($userId) {
            $query->where('employe_id', $userId);
        })->findOrFail($id);

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
        // Ici, on ne filtre pas par employé car c’est une API publique ou admin
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
