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

        $immeubleIds = $user->immeubles()->select('immeuble.id')->pluck('id');

        $residenceIds = Immeuble::whereIn('id', $immeubleIds)
            ->whereNotNull('residence_id')
            ->pluck('residence_id')
            ->unique();

        $appartementIds = Appartement::whereIn('immeuble_id', $immeubleIds)->pluck('id_A');

        $creationDate = $user->created_at ?? now();
        $startMonth = Carbon::parse($creationDate)->startOfMonth();
        $currentMonth = Carbon::now()->startOfMonth();

        // List all months of the current year (January to December)
        $yearStart = Carbon::now()->startOfYear();

        $months = [];
        $tempMonth = $startMonth->copy();
        while ($tempMonth->lessThanOrEqualTo($currentMonth)) {
            $months[] = $tempMonth->format('Y-m');
            $tempMonth->addMonth();
        }


        $month = $request->input('month', Carbon::now()->format('Y-m'));
        [$year, $monthNum] = explode('-', $month);
        $startDate = "$year-$monthNum-01";
        $endDate = date("Y-m-t", strtotime($startDate));

        $nbImmeubles = $immeubleIds->count();
        $nbAppartements = $appartementIds->count();
        $nbResidences = $residenceIds->count();
        $nbEmployes = 0;

        $totalPaiements = Paiement::whereIn('id_A', $appartementIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('montant');

        $totalCharges = Charge::whereIn('immeuble_id', $immeubleIds)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('montant');

        $totalSalaires = 0;
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
            }, $months),
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
            'months', 'month',
            'nbImmeubles', 'nbAppartements', 'nbResidences', 'nbEmployes',
            'totalPaiements', 'totalCharges', 'totalSalaires',
            'chiffreAffairesNet', 'caisseDisponible', 'chargesImmeubles','chartData'
        ));
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
