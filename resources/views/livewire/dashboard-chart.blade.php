<div>
    <canvas id="dashboardChart" width="100%" height="40"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('dashboardChart').getContext('2d');

            const data = @json($chartData);

            // Palette bleu marine et gris
            const colors = [
                '#2c3e50', // Bleu marine
                '#7f8c8d', // Gris foncé
                '#bdc3c7', // Gris clair
                '#95a5a6', // Gris moyen
                '#2c3e50', // Bleu marine (répété)
                '#7f8c8d', // Gris foncé (répété)
                '#bdc3c7'  // Gris clair (répété)
            ];

            // Appliquer les couleurs aux datasets
            data.datasets.forEach((dataset, index) => {
                dataset.backgroundColor = colors[index % colors.length];
                dataset.borderColor = colors[index % colors.length];
                dataset.borderWidth = 1;
                dataset.borderRadius = 6;
                dataset.barThickness = 30;
            });

            const dashboardChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: data.datasets
                },
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    stacked: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Taux de paiement des charges par mois (DH)',
                            color: '#2c3e50',
                            font: {
                                size: 18,
                                weight: 'bold'
                            }
                        },
                        legend: {
                            labels: {
                                color: '#2c3e50',
                                font: {
                                    size: 12
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#2c3e50'
                            },
                            grid: {
                                color: '#ecf0f1'
                            }
                        },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Montant (DH)',
                                color: '#2c3e50'
                            },
                            ticks: {
                                color: '#2c3e50'
                            },
                            grid: {
                                color: '#ecf0f1'
                            }
                        },
                        percentage: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            min: 0,
                            max: 100,
                            title: {
                                display: true,
                                text: 'Taux de paiement (%)',
                                color: '#2c3e50'
                            },
                            grid: {
                                drawOnChartArea: false
                            },
                            ticks: {
                                color: '#2c3e50'
                            }
                        }
                    }
                }
            });
        });
    </script>
</div>
