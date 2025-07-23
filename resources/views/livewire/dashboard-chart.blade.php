<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tableau de bord</title>
    <style>
        /* (garde tout ton CSS existant, inchangé) */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8fafc;
            color: #1e293b;
            line-height: 1.6;
            padding: 32px;
        }
        .dashboard-wrapper {
            max-width: 1200px;
            margin: 0 auto;
        }
        .dashboard-header {
            margin-bottom: 32px;
        }
        .dashboard-title {
            font-size: 32px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
            letter-spacing: -0.025em;
        }
        .dashboard-subtitle {
            font-size: 16px;
            color: #64748b;
            font-weight: 400;
        }
        .chart-container {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 4px 24px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            padding: 32px;
            position: relative;
            overflow: hidden;
        }
        .chart-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #06b6d4);
        }
        .chart-wrapper {
            position: relative;
            height: 500px;
            margin-top: 16px;
        }
        #dashboardChart {
            width: 100% !important;
            height: 100% !important;
        }
        @media (max-width: 768px) {
            body { padding: 20px; }
            .dashboard-title { font-size: 24px; }
            .chart-container { padding: 20px; }
            .chart-wrapper { height: 400px; }
        }
        @media (max-width: 480px) {
            body { padding: 16px; }
            .dashboard-title { font-size: 20px; }
            .chart-container { padding: 16px; }
        }
    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <div class="chart-container">
            <div class="chart-wrapper">
                <canvas id="dashboardChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Injection des données PHP dans JS via Blade
        const chartData = {!! json_encode($chartData) !!};

        const ctx = document.getElementById('dashboardChart').getContext('2d');

        const dashboardChart = new Chart(ctx, {
            data: {
                labels: chartData.labels,
                datasets: chartData.datasets.map(ds => {
                    // Force tout en barres
                    return {
                        ...ds,
                        type: 'bar',
                        backgroundColor: ds.backgroundColor || 'rgba(255, 0, 0, 0.7)',
                        borderColor: ds.borderColor || 'rgba(59, 130, 246, 1)',
                        borderWidth: 1,
                        borderRadius: 8,
                        barThickness: 32,
                        hoverBackgroundColor: ds.hoverBackgroundColor || 'rgba(37, 99, 235, 0.8)',
                        fill: true,
                    };
                }),
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                stacked: false,
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Montant (DH)',
                            color: '#1e293b',
                            font: {
                                size: 14,
                                weight: '600'
                            }
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                size: 13
                            },
                            callback: function(value) {
                                return value + ' DH';
                            }
                        },
                        grid: {
                            color: '#f1f5f9',
                            lineWidth: 1
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
                            color: '#1e293b',
                            font: {
                                size: 14,
                                weight: '600'
                            }
                        },
                        grid: {
                            drawOnChartArea: false
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                size: 13
                            },
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#1e293b',
                            font: {
                                size: 14,
                                weight: '500'
                            },
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'rectRounded'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Taux de paiement des charges par mois (DH)',
                        color: '#1e293b',
                        font: {
                            size: 20,
                            weight: '600'
                        },
                        padding: {
                            bottom: 30
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
