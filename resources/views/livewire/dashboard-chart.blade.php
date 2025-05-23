<div class="w-full flex justify-center mt-6">
    <div style="width: 100%; max-width: 1000px;">
        <h3 class="text-center text-lg font-semibold mb-4">Taux de paiement des charges par mois (€)</h3>
        <canvas id="chartPaiementCharges"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('chartPaiementCharges').getContext('2d');
        const chartData = @json($chartData);

        new Chart(ctx, {
            data: chartData,
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                stacked: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Montant (€)'
                        }
                    },
                    percentage: {
                        position: 'right',
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        },
                        title: {
                            display: true,
                            text: 'Taux (%)'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                }
            }
        });
    });
</script>
