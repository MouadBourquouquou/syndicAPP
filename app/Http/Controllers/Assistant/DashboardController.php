<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Immeuble;
use App\Models\Appartement;
use App\Models\Paiement;
use App\Models\Charge;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;

        $immeubleIds = $user->immeubles()->select('immeuble.id')->pluck('id');

        $residenceIds = Immeuble::whereIn('id', $immeubleIds)
            ->whereNotNull('residence_id')
            ->pluck('residence_id')
            ->unique();

        $appartementIds = Appartement::whereIn('immeuble_id', $immeubleIds)->pluck('id_A');

        // User creation date or now
        $creationDate = $user->created_at ?? now();

        $startMonth = Carbon::parse($creationDate)->startOfMonth();
        $currentMonth = Carbon::now()->startOfMonth();

        // List all months of the current year (January to December)
        $yearStart = Carbon::now()->startOfYear();
        $months = [];

        // mounth from start month to current month
        $tempMonth = $startMonth->copy();
        while ($tempMonth->lessThanOrEqualTo($currentMonth)) {
            $months[] = $tempMonth->format('Y-m');
            $tempMonth->addMonth();
        }

        // Selected month param or latest
        $month = $request->input('month', end($months));
        $immeubleId = $request->input('immeuble_id');

        // Parse selected month start/end
        $year = substr($month, 0, 4);
        $monthNum = substr($month, 5, 2);
        $startDate = "$year-$monthNum-01";
        $endDate = date("Y-m-t", strtotime($startDate));

        if ($immeubleId) {
            $immeubleIds = [$immeubleId];
            $immeubleMode = true;
        } else {
            // Otherwise, use all accessible immeubles for this user

             // Immeubles liés à l'employé connecté
            $immeubleIds = Immeuble::withCount('appartements')
                ->whereHas('employes', function($query) use ($userId) {
                    $query->where('employe_id', $userId);
                })
                ->pluck('id')->toArray();
            $immeubleMode = false;
        }

        $immeubles = Immeuble::whereHas('employes', function ($query) use ($userId) {
            $query->where('employe_id', $userId);
        })->get();
        $nbImmeubles = count($immeubleIds);
        $nbAppartements = $appartementIds->count();
        $nbResidences = $residenceIds->count();
        $nbEmployes = 0;

        $totalPaiements = Paiement::whereIn('id_A', $appartementIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('montant');

        $totalCharges = Charge::whereIn('immeuble_id', $immeubleIds)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('montant');

        $chiffreAffairesNet = $totalPaiements - $totalCharges;
        $caisseDisponible = $chiffreAffairesNet;

        $chargesImmeubles = Charge::whereIn('immeuble_id', $immeubleIds)
            ->whereBetween('date', [$startDate, $endDate])
            ->select('immeuble_id', DB::raw('SUM(montant) as total'))
            ->groupBy('immeuble_id')
            ->get()
            ->mapWithKeys(function ($item) {
                $immeuble = Immeuble::find($item->immeuble_id);
                $nom = $immeuble ? ($immeuble->nom ?? "Immeuble #{$item->immeuble_id}") : "Immeuble #{$item->immeuble_id}";
                return [$nom => $item->total];
            });

        // Build chart data by month
        $paymentsData = [];
        $chargesData = [];
        $chargePaye = [];
        $chargeNonPaye = [];
        foreach ($months as $m) {
            $y = substr($month, 0, 4);
            $mn = substr($month, 5, 2);
            $sd = "$y-$mn-01";
            $ed = date("Y-m-t", strtotime($sd));

            $paymentsData[] = Paiement::whereIn('id_A', $appartementIds)
                ->whereBetween('created_at', [$sd, $ed])
                ->sum('montant');

            $chargesData[] = Charge::whereIn('immeuble_id', $immeubleIds)
                ->whereBetween('date', [$sd, $ed])
                ->sum('montant');

            $chargePaye[] = Charge::whereIn('immeuble_id', $immeubleIds)
                ->where('etat', 'payée')
                ->whereBetween('date', [$sd, $ed])
                ->sum('montant');

            $chargeNonPaye[] = Charge::whereIn('immeuble_id', $immeubleIds)
                ->where('etat', 'non payée')
                ->whereBetween('date', [$sd, $ed])
                ->sum('montant');

         }

        $chartData = [
            'labels' => [Carbon::parse($month . '-01')->translatedFormat('M Y')],
            'datasets' => [
                [
                    'label' => 'Total Paiements',
                    'data' => $paymentsData,
                    'type' => 'bar',
                    'backgroundColor' => '#3b82f6', // bleu
                ],
                [
                    'label' => 'Total Charges',
                    'data' => $chargesData,
                    'type' => 'bar',
                    'backgroundColor' => '#ff9d00ff', // rouge
                    'fill' => true,
                ],
                [
                    'label' => 'Charges Payées',
                    'data' => $chargePaye,
                    'type' => 'bar',
                    'backgroundColor' => '#44ef52ff', // rouge
                    'fill' => true,
                ],
                [
                    'label' => 'Charges Dues',
                    'data' => $chargeNonPaye,
                    'type' => 'bar',
                    'backgroundColor' => '#ef4444', // rouge
                    'fill' => true,
                ],
            ],
        ];

        return view('assistant.dashboard', compact(
            'months', 'month','immeubles',
            'nbImmeubles', 'nbAppartements', 'nbResidences', 'nbEmployes',
            'totalPaiements', 'totalCharges',
            'chiffreAffairesNet', 'caisseDisponible', 'chargesImmeubles','chartData','chargePaye', 'chargeNonPaye',
        ));
    }
    
public function fetchData(Request $request)
{
    $user = Auth::user();
    $userId = $user->id;
    $immeubles = Immeuble::whereHas('employes', function ($query) use ($userId) {
            $query->where('employe_id', $userId);
        })->get();
    $selectedMonth = $request->input('month', now()->format('Y-m'));
    $immeubleId = $request->input('immeuble_id');

    // Parse dates from selected month
    $year = substr($selectedMonth, 0, 4);
    $monthNum = substr($selectedMonth, 5, 2);
    $startDate = "$year-$monthNum-01";
    $endDate = date("Y-m-t", strtotime($startDate));

    // Immeuble filtering logic
    if ($immeubleId) {
        // Single selected immeuble
        $immeubleIds = [$immeubleId];
        $immeubleMode = true;
    } else {
        // All immeubles accessible to this assistant via 'employes' relation
        $immeubleIds = Immeuble::whereHas('employes', function ($query) use ($userId) {
            $query->where('employe_id', $userId);
        })->pluck('id')->toArray();

        $immeubleMode = false;
    }

    // Appartement IDs for those immeubles
    $appartementIds = Appartement::whereIn('immeuble_id', $immeubleIds)->pluck('id_A');
    $nbAppartements = Appartement::whereIn('immeuble_id', $immeubleIds)->count();

    // Totals
    $totalPaiements = Paiement::whereIn('id_A', $appartementIds)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->sum('montant');

    $totalCharges = Charge::whereIn('immeuble_id', $immeubleIds)
        ->whereBetween('date', [$startDate, $endDate])
        ->sum('montant');

    $chargePaye = Charge::whereIn('immeuble_id', $immeubleIds)
        ->where('etat', 'payée')
        ->whereBetween('date', [$startDate, $endDate])
        ->sum('montant');

    $chargeNonPaye = Charge::whereIn('immeuble_id', $immeubleIds)
        ->where('etat', 'non payée')
        ->whereBetween('date', [$startDate, $endDate])
        ->sum('montant');


    $chiffreAffairesNet = $totalPaiements - $totalCharges;
    $caisseDisponible = Immeuble::whereIn('id', $immeubleIds)->sum('caisse');

    // Chart data for frontend
    $chartData = [
        'labels' => [Carbon::parse($selectedMonth . '-01')->translatedFormat('M Y')],
        'datasets' => [
            [
                'label' => 'Total Paiements',
                'data' => [$totalPaiements],
                'backgroundColor' => '#3b82f6',
            ],
            [
                'label' => 'Total Charges',
                'data' => [$totalCharges],
                'backgroundColor' => '#ff9d00ff',
            ],
            [
                'label' => 'Charges Payées',
                'data' => [$chargePaye],
                'backgroundColor' => '#44ef52ff',
            ],
            [
                'label' => 'Charges Dues',
                'data' => [$chargeNonPaye],
                'backgroundColor' => '#ef4444',
            ],
        ],
    ];

    return response()->json([
        'immeuble_mode' => $immeubleMode,
        'immeubles' => $immeubles,
        'totalPaiements' => $totalPaiements,
        'totalCharges' => $totalCharges,
        'chargePaye' => $chargePaye,
        'chargeNonPaye' => $chargeNonPaye,
        'chiffreAffairesNet' => $chiffreAffairesNet,
        'caisseDisponible' => $caisseDisponible,
        'nbAppartements' => $nbAppartements,
        'chartData' => $chartData,
    ]);
}



    public function historique()
    {
        $user = Auth::user();

        $immeubleIds = $user->immeubles()->pluck('id');
        $appartementIds = Appartement::whereIn('immeuble_id', $immeubleIds)->pluck('id_A');

        $paiements = Paiement::with('appartement')
            ->whereIn('id_A', $appartementIds)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('assistant.historique', compact('paiements'));
    }
}
