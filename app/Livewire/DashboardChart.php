<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Paiement;
use App\Models\Charge;
use App\Models\Immeuble;
use App\Models\Appartement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardChart extends Component
{
    public $chartData;

    public function mount()
    {
        $userId = Auth::id();

        $immeubleIds = Immeuble::where('id_S', $userId)->pluck('id');
        $appartementIds = Appartement::whereIn('immeuble_id', $immeubleIds)->pluck('id_A');

        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $months->push(Carbon::now()->subMonths($i)->format('Y-m'));
        }

        $labels = $months->map(fn ($m) => Carbon::parse($m . '-01')->translatedFormat('M Y'))->toArray();

        $chargesPayees = [];
        $chargesDues = [];

        foreach ($months as $m) {
            $start = Carbon::parse($m . '-01')->startOfMonth();
            $end = $start->copy()->endOfMonth();

            $payees = Paiement::whereIn('id_A', $appartementIds)
                ->whereBetween('created_at', [$start, $end])
                ->sum('montant');

            $dues = Charge::whereIn('immeuble_id', $immeubleIds)
                ->whereBetween('date', [$start, $end])
                ->sum('montant');

            $chargesPayees[] = $payees;
            $chargesDues[] = $dues;
        }

        // Calculate payment rate %
        $tauxPaiement = [];
        foreach ($chargesDues as $i => $due) {
            $pourcentage = $due > 0 ? round(($chargesPayees[$i] / $due) * 100, 2) : 0;
            $tauxPaiement[] = $pourcentage;
        }

        $this->chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Charges payées (DH)',
                    'data' => $chargesPayees,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.6)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                    'type' => 'bar',
                ],
                [
                    'label' => 'Charges dues (DH)',
                    'data' => $chargesDues,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.4)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1,
                    'type' => 'bar',
                ],
                [
                    'label' => 'Taux de paiement (%)',
                    'data' => $tauxPaiement,
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.1)',
                    'borderWidth' => 2,
                    'type' => 'bar',
                    'yAxisID' => 'percentage',
                ],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.dashboard-chart');
    }
}
