<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\Charge;
use App\Models\Appartement;
use App\Models\Immeuble;
use App\Models\Employe;
use App\Models\Residence;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;

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
        $selectedMonth = $request->input('month', end($months));

        // Parse selected month start/end
        $year = substr($selectedMonth, 0, 4);
        $monthNum = substr($selectedMonth, 5, 2);
        $startDate = "$year-$monthNum-01";
        $endDate = date("Y-m-t", strtotime($startDate));

        // Get user's immeuble IDs and appartement IDs
        $immeubleIds = Immeuble::where('id_S', $userId)->pluck('id');
        $appartementIds = Appartement::whereIn('immeuble_id', $immeubleIds)->pluck('id_A');

        // Summary counts
        $nbImmeubles = $immeubleIds->count();
        $nbAppartements = $appartementIds->count();
        $nbEmployes = Employe::where('id_S', $userId)->count();
        $nbResidences = Residence::where('id_S', $userId)->count();

        // Totals for selected month
        $totalPaiements = Paiement::whereIn('id_A', $appartementIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('montant');

        $totalCharges = Charge::whereIn('immeuble_id', $immeubleIds)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('montant');

        $totalSalaires = Employe::where('id_S', $userId)->sum('salaire');

        $chiffreAffairesNet = $totalPaiements - $totalCharges - $totalSalaires;
        $caisseDisponible = $chiffreAffairesNet;

        // Build chart data by month
        $paymentsData = [];
        $chargesData = [];
        $chargePaye = [];
        $chargeNonPaye=[];
        foreach ($months as $m) {
            $y = substr($m, 0, 4);
            $mn = substr($m, 5, 2);
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
            'labels' => array_map(function ($m) {
                return Carbon::parse($m . '-01')->translatedFormat('M Y');
            }, [$selectedMonth]),
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

        return view('dashboard', [
            'nbImmeubles' => $nbImmeubles,
            'nbAppartements' => $nbAppartements,
            'nbEmployes' => $nbEmployes,
            'nbResidences' => $nbResidences,
            'totalPaiements' => $totalPaiements,
            'totalCharges' => $totalCharges,
            'totalSalaires' => $totalSalaires,
            'chiffreAffairesNet' => $chiffreAffairesNet,
            'caisseDisponible' => $caisseDisponible,
            'month' => $selectedMonth,
            'months' => $months,
            'chartData' => $chartData,
        ]);
    }

    public function historique()
    {
        $userId = Auth::id();

        $immeubleIds = Immeuble::where('id_S', $userId)->pluck('id');
        $appartementIds = Appartement::whereIn('immeuble_id', $immeubleIds)->pluck('id_A');

        $paiements = Paiement::with(['appartement', 'charge'])
            ->whereIn('id_A', $appartementIds)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('historique', compact('paiements'));
    }
}
