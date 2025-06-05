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

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques simples
        $nbImmeubles = Immeuble::count();
        $nbAppartements = Appartement::count();
        $nbEmployes = Employe::count();
        $nbResidences = Residence::count();

        $chiffreAffaires = Paiement::sum('montant');
        $totalCharges = Charge::sum('montant');
        $caisseDisponible = $chiffreAffaires - $totalCharges;

        // Données des charges dues par mois
        $chargesParMois = Charge::select(
            DB::raw('MONTH(date) as mois'),
            DB::raw('SUM(montant) as total_charge')
        )
            ->groupBy('mois')
            ->orderBy('mois')
            ->pluck('total_charge', 'mois')
            ->toArray();

        // Données des paiements par mois
        $paiementsParMois = Paiement::select(
            DB::raw('MONTH(mois_paye) as mois'),
            DB::raw('SUM(montant) as total_paye')
        )
            ->groupBy('mois')
            ->orderBy('mois')
            ->pluck('total_paye', 'mois')
            ->toArray();

        // Labels des mois
        $labels = [];
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = date('F', mktime(0, 0, 0, $i, 10)); // Janvier, Février, ...
        }

        // Préparer les datasets
        $chargesData = [];
        $paiementsData = [];
        $tauxData = [];

        for ($i = 1; $i <= 12; $i++) {
            $charge = $chargesParMois[$i] ?? 0;
            $paiement = $paiementsParMois[$i] ?? 0;

            $chargesData[] = $charge;
            $paiementsData[] = $paiement;

            // Calcul du taux de paiement
            $taux = ($charge > 0) ? round(($paiement / $charge) * 100, 2) : 0;
            $tauxData[] = $taux;
        }

        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Charges dues',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'borderWidth' => 1,
                    'data' => $chargesData,
                    'yAxisID' => 'y',
                    'type' => 'bar',
                ],
                [
                    'label' => 'Charges payées',
                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                    'borderColor' => 'rgb(54, 162, 235)',
                    'borderWidth' => 1,
                    'data' => $paiementsData,
                    'yAxisID' => 'y',
                    'type' => 'bar',
                ],
                [
                    'label' => 'Taux de paiement (%)',
                    'data' => $tauxData,
                    'borderColor' => 'rgb(255, 206, 86)',
                    'backgroundColor' => 'rgba(255, 206, 86, 0.5)',
                    'type' => 'line',
                    'yAxisID' => 'percentage',
                    'tension' => 0.4,
                    'fill' => false,
                ]
            ],
        ];

        return view('dashboard', compact(
            'nbImmeubles',
            'nbAppartements',
            'nbEmployes',
            'nbResidences',
            'chiffreAffaires',
            'caisseDisponible',
            'chartData'
        ));
    }
}
