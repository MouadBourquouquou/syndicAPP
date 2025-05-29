<?php
namespace App\Livewire;

use Livewire\Component;

class DashboardChart extends Component
{
    public $chartData;

    public function mount()
    {
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $chargesPayees = [1200, 1500, 1300, 1700, 1800, 1600, 1900, 2000, 2100, 1950, 2200, 2300];
        $chargesDues =   [1500, 1600, 1500, 1800, 1900, 1700, 2000, 2100, 2200, 2100, 2300, 2400];

        // Calcul des pourcentages
        $tauxPaiement = [];
        foreach ($chargesPayees as $i => $payee) {
            $due = $chargesDues[$i];
            $pourcentage = $due > 0 ? round(($payee / $due) * 100, 2) : 0;
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
                    'type' => 'bar'
                ],
                [
                    'label' => 'Charges dues (DH)',
                    'data' => $chargesDues,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.4)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1,
                    'type' => 'bar'
                ],
                [
                    'label' => 'Taux de paiement (%)',
                    'data' => $tauxPaiement,
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.1)',
                    'borderWidth' => 2,
                    'type' => 'line',
                    'yAxisID' => 'percentage'
                ],
            ]
        ];
    }

    public function render()
    {
        return view('livewire.dashboard-chart');
    }
}