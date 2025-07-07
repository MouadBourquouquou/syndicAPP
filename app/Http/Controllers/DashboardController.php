<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\Charge;
use App\Models\Appartement;
use App\Models\Immeuble;
use App\Models\Employe;
use App\Models\Residence;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
<<<<<<< HEAD
        $user = Auth::user();
        $userId = $user->id;

        $creationDate = $user->created_at ?? now();

=======
        $userId = Auth::id();
        $creationDate = Auth::user()->created_at ?? now();

        // Generate months only from user's activity (optional: can filter further)
>>>>>>> 776ed89 (updated design)
        $startMonth = Carbon::parse($creationDate)->startOfMonth();
        $currentMonth = Carbon::now()->startOfMonth();
        $months = [];
        while ($startMonth->lessThanOrEqualTo($currentMonth)) {
            $months[] = $startMonth->format('Y-m');
            $startMonth->addMonth();
        }

        $month = $request->input('month', Carbon::now()->format('Y-m'));
        $year = substr($month, 0, 4);
        $monthNum = substr($month, 5, 2);
        $startDate = "$year-$monthNum-01";
        $endDate = date("Y-m-t", strtotime($startDate));

<<<<<<< HEAD
        $immeubleIds = Immeuble::where('id_S', $userId)->pluck('id');
        $appartementIds = Appartement::whereIn('immeuble_id', $immeubleIds)->pluck('id_A');

        $nbImmeubles = $immeubleIds->count();
        $nbAppartements = $appartementIds->count();
        $nbEmployes = Employe::where('id_S', $userId)->count();
        $nbResidences = Residence::where('id_S', $userId)->count();


        $totalPaiements = Paiement::whereIn('id_A', $appartementIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('montant');

        $totalCharges = Charge::whereIn('immeuble_id', $immeubleIds)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('montant');


        $totalSalaires = Employe::where('id_S', $userId)->sum('salaire');

        $chiffreAffairesNet = $totalPaiements - $totalCharges - $totalSalaires;
        $caisseDisponible = $chiffreAffairesNet;


        $chargesImmeubles = Charge::whereIn('immeuble_id', $immeubleIds)
=======
        // Get IDs of user's immeubles
        $immeubleIds = Immeuble::where('id_S', $userId)->pluck('id')->toArray();

        $nbImmeubles = count($immeubleIds);
        $nbAppartements = Appartement::whereIn('immeuble_id', $immeubleIds)->count();
        $nbEmployes = Employe::where('id_S', $userId)->count();
        $nbResidences = Residence::where('id_S', $userId)->count();

        // Sum Paiements safely: via appartement -> immeuble -> id_S
        $totalPaiements = Paiement::whereHas('appartement.immeuble', function ($q) use ($userId) {
            $q->where('id_S', $userId);
        })->whereBetween('created_at', [$startDate, $endDate])->sum('montant');

        $totalCharges = Charge::where('id_S', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('montant');

        $totalSalaires = Employe::where('id_S', $userId)->sum('salaire');

        $chiffreAffairesNet = $totalPaiements - $totalCharges - $totalSalaires;
        $caisseDisponible = $chiffreAffairesNet;

        // Charges by Immeuble name
        $chargesImmeubles = Charge::select('immeuble_id', DB::raw('SUM(montant) as total'))
            ->where('id_S', $userId)
>>>>>>> 776ed89 (updated design)
            ->whereBetween('date', [$startDate, $endDate])
            ->select('immeuble_id', DB::raw('SUM(montant) as total'))
            ->groupBy('immeuble_id')
            ->get()
            ->mapWithKeys(function ($item) {
                $immeuble = Immeuble::find($item->immeuble_id);
                $nom = $immeuble ? ($immeuble->nom ?? "Immeuble #{$item->immeuble_id}") : "Immeuble #{$item->immeuble_id}";
                return [$nom => $item->total];
            });

<<<<<<< HEAD
=======
        // Chart data
        $paiementsParMois = [];
        $chargesParMois = [];

        foreach ($months as $m) {
            $start = Carbon::parse($m)->startOfMonth();
            $end = Carbon::parse($m)->endOfMonth();

            $paiementsParMois[] = Paiement::whereHas('appartement.immeuble', function ($q) use ($userId) {
                $q->where('id_S', $userId);
            })->whereBetween('created_at', [$start, $end])->sum('montant');

            $chargesParMois[] = Charge::where('id_S', $userId)
                ->whereBetween('date', [$start, $end])
                ->sum('montant');
        }

        // Taux de paiement (%) par mois
        $tauxPaiement = [];
        foreach ($paiementsParMois as $i => $paiement) {
            $charge = $chargesParMois[$i] ?: 1; // avoid division by 0
            $tauxPaiement[] = round(($paiement / $charge) * 100, 2);
        }

        $chartData = [
            'labels' => array_map(function ($m) {
                return Carbon::parse($m)->format('M Y');
            }, $months),
            'datasets' => [
                [
                    'label' => 'Charges Dues',
                    'data' => $chargesParMois,
                    'yAxisID' => 'y',
                ],
                [
                    'label' => 'Charges Payées',
                    'data' => $paiementsParMois,
                    'yAxisID' => 'y',
                ],
                [
                    'label' => 'Taux de paiement (%)',
                    'data' => $tauxPaiement,
                    'type' => 'line',
                    'yAxisID' => 'percentage',
                ],
            ],
        ];

>>>>>>> 776ed89 (updated design)
        return view('dashboard', [
            'months' => $months,
            'month' => $month,
            'nbImmeubles' => $nbImmeubles,
            'nbAppartements' => $nbAppartements,
            'nbEmployes' => $nbEmployes,
            'nbResidences' => $nbResidences,
            'totalPaiements' => $totalPaiements,
            'totalCharges' => $totalCharges,
            'totalSalaires' => $totalSalaires,
            'chiffreAffairesNet' => $chiffreAffairesNet,
            'caisseDisponible' => $caisseDisponible,
            'chargesImmeubles' => $chargesImmeubles,
<<<<<<< HEAD
            'month' => $month,
            'months' => $months,
=======
            'chartData' => $chartData
>>>>>>> 776ed89 (updated design)
        ]);
    }

    public function historique()
    {
<<<<<<< HEAD
        $userId = auth()->id();

        $immeubleIds = Immeuble::where('id_S', $userId)->pluck('id');
        $appartementIds = Appartement::whereIn('immeuble_id', $immeubleIds)->pluck('id');

        $paiements = Paiement::with(['appartement', 'charge'])
            ->whereIn('id_A', $appartementIds)
=======
        $userId = Auth::id();

        $paiements = Paiement::whereHas('appartement.immeuble', function ($q) use ($userId) {
            $q->where('id_S', $userId);
        })->with(['appartement', 'charge'])
>>>>>>> 776ed89 (updated design)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('historique', compact('paiements'));
    }
}
