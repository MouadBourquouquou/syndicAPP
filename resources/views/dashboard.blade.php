@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<style>
    .custom-box {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        padding: 18px;
        height: 100%;
        position: relative;
    }

    .custom-box .inner h3 {
        font-size: 28px;
        margin-bottom: 10px;
        color: #343a40;
    }

    .custom-box .inner p {
        font-size: 16px;
        color: #6c757d;
    }

    .custom-box .icon {
        font-size: 30px;
        position: absolute;
        top: 20px;
        right: 5%;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 20px;
            }
            
            .dashboard-title {
                font-size: 24px;
            }
            
            .chart-container {
                padding: 20px;
            }
            
            .chart-wrapper {
                height: 400px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 16px;
            }
            
            .dashboard-title {
                font-size: 20px;
            }
            
            .chart-container {
                padding: 16px;
            }
        }
    

    .border-red { border-left: 5px solid #e74c3c; }
    .border-green { border-left: 5px solid #27ae60; }
    .border-blue { border-left: 5px solid #3498db; }
    .border-purple { border-left: 5px solid #9b59b6; }
    .border-orange { border-left: 5px solid #f39c12; }
    .border-teal { border-left: 5px solid #1abc9c; }
    .border-gray { border-left: 5px solid #7f8c8d; }
    .border-darkblue { border-left: 5px solid #34495e; }

    .icon-red { color: #e74c3c; }
    .icon-green { color: #27ae60; }
    .icon-blue { color: #3498db; }
    .icon-purple { color: #9b59b6; }
    .icon-orange { color: #f39c12; }
    .icon-teal { color: #1abc9c; }
    .icon-gray { color: #7f8c8d; }
    .icon-darkblue { color: #34495e; }

    /* Modern form styling */
    .form-label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.5rem;
        font-size: 15px;
    }

    .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 15px;
        background-color: #ffffff;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px 12px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        min-width: 200px;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    .form-select:hover {
        border-color: #cbd5e0;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }

    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-primary:hover::before {
        left: 100%;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .price {
        color: #2c2d2e;
        font-size: 19px;
        font-weight: 500;
    }

    /* Form container styling */
    .mb-4 {
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
        margin-bottom: 2rem;
    }

    .row.justify-content-center.align-items-center {
        gap: 12px;
    }

    /* Responsive dashboard cards */
    .dashboard-card {
        margin-bottom: 1.5rem;
    }

    .dashboard-stats {
        margin-left: -0.75rem;
        margin-right: -0.75rem;
    }

    .dashboard-stats > [class*="col-"] {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }

    /* Enhanced responsive breakpoints */
    @media (max-width: 576px) {
        .dashboard-stats > [class*="col-"] {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        
        .dashboard-card {
            margin-bottom: 1rem;
        }
        
        .custom-box {
            padding: 16px;
        }
        
        .custom-box .inner h3 {
            font-size: 24px;
        }
        
        .custom-box .icon {
            font-size: 24px;
            top: 16px;
            right: 16px;
        }
        
        .price {
            font-size: 16px;
        }
        
        .form-select {
            min-width: 150px;
        }
        
        .btn-primary {
            padding: 10px 20px;
            font-size: 14px;
        }
        
        .mb-4 {
            padding: 20px;
        }
    }

    @media (max-width: 768px) {
        .dashboard-stats {
            margin-left: -0.5rem;
            margin-right: -0.5rem;
        }
        
        .dashboard-stats > [class*="col-"] {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        
        .form-select {
            min-width: 150px;
        }
        
        .btn-primary {
            padding: 10px 20px;
            font-size: 14px;
        }
        
        .mb-4 {
            padding: 20px;
        }
    }

    @media (min-width: 769px) and (max-width: 991px) {
        .custom-box .inner h3 {
            font-size: 26px;
        }
        
        .price {
            font-size: 18px;
        }
    }

    @media (min-width: 992px) {
        .dashboard-stats > [class*="col-"] {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
    }
</style>

<div class="container">
    <!-- Formulaire de sélection du mois via <select> -->
    <form method="GET" action="{{ route('dashboard') }}" class="mb-4">
        @csrf
        <div class="row justify-content-center align-items-center">
            <div class="col-auto">
                <label for="month" class="form-label">Choisir le mois :</label>
            </div>
            <div class="col-auto">
                <select name="month" id="month" class="form-select" required>
                    @foreach ($months as $mois)
                        <option value="{{ $mois }}" {{ $mois == $month ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::parse($mois . '-01')->translatedFormat('F Y') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Afficher</button>
            </div>
        </div>
    </form>

    <!-- Financial Statistics -->
    <div class="row dashboard-stats">
        <div class="col-lg-3 col-md-6 col-sm-12 dashboard-card">
            <div class="custom-box border-green">
                <p class="price">{{ number_format($totalPaiements, 2, ',', ' ') }} DH</p>
                <div class="inner">
                    <p>Total Paiements</p>
                </div>
                <div class="icon icon-green">
                    <i class="fas fa-coins"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 col-sm-12 dashboard-card">
            <div class="custom-box border-red">
                <p class="price">{{ number_format($totalCharges, 2, ',', ' ') }} DH</p>
                <div class="inner">
                    <p>Total Charges</p>
                </div>
                <div class="icon icon-red">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 col-sm-12 dashboard-card">
            <div class="custom-box border-orange">
                <p class="price">{{ number_format($totalSalaires, 2, ',', ' ') }} DH</p>
                <div class="inner">
                    <p>Total Salaires</p>
                </div>
                <div class="icon icon-orange">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 col-sm-12 dashboard-card">
            <div class="custom-box border-blue">
                <p class="price">{{ number_format($chiffreAffairesNet, 2, ',', ' ') }} DH</p>
                <div class="inner">
                    <p>Chiffre d'affaires net</p>
                </div>
                <div class="icon icon-blue">
                    <i class="fas fa-calculator"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 col-sm-12 dashboard-card">
            <div class="custom-box border-teal">
                <p class="price">{{ number_format($caisseDisponible, 2, ',', ' ') }} DH</p>
                <div class="inner">
                    <p>Caisse disponible</p>
                </div>
                <div class="icon icon-teal">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 col-sm-12 dashboard-card">
            <div class="custom-box border-orange">
                <p class="price">{{ $nbImmeubles }}</p>
                <div class="inner">
                    <p>Immeubles</p>
                </div>
                <div class="icon icon-orange">
                    <i class="fas fa-building"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 col-sm-12 dashboard-card">
            <div class="custom-box border-purple">
                <p class="price">{{ $nbResidences }}</p>
                <div class="inner">
                    <p>Résidences</p>
                </div>
                <div class="icon icon-purple">
                    <i class="fas fa-city"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 col-sm-12 dashboard-card">
            <div class="custom-box border-teal">
                <p class="price">{{ $nbAppartements }}</p>
                <div class="inner">
                    <p>Appartements</p>
                </div>
                <div class="icon icon-teal">
                    <i class="fas fa-home"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 col-sm-12 dashboard-card">
            <div class="custom-box border-gray">
                <p class="price">{{ $nbEmployes }}</p>
                <div class="inner">
                    <p>Employés</p>
                </div>
                <div class="icon icon-gray">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

   
    

<div class="dashboard-wrapper">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Tableau de bord des paiements</h1>
            <p class="dashboard-subtitle">Analyse des charges et taux de paiement mensuels</p>
        </div>

        <div class="chart-container">
            <div class="chart-wrapper">
                <canvas id="dashboardChart"></canvas>
            </div>
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
                    if(ds.type === 'line') {
                        return {
                            ...ds,
                            fill: false,
                            borderColor: '#f59e0b',
                            backgroundColor: 'rgba(245, 158, 11, 0.1)',
                            borderWidth: 3,
                            pointRadius: 6,
                            pointBackgroundColor: '#f59e0b',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 3,
                            pointHoverRadius: 8,
                            tension: 0.4,
                        };
                    }
                    // Configuration pour les barres
                    return {
                        ...ds,
                        backgroundColor: '#00000',
                        borderColor: '#00000',
                        borderWidth: 0,
                        borderRadius: 8,
                        barThickness: 32,
                        hoverBackgroundColor: '#2563eb',
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
                            color: '#475569',
                            font: {
                                size: 14,
                                weight: '500'
                            },
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
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
@endsection