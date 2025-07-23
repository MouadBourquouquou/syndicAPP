@php
    $layout = auth()->user()->statut === 'assistant_syndic' ? 'assistant.layouts.app' : 'layouts.app';
@endphp

@extends($layout)
@section('title', 'Dashboard')
@section('content')

<style>
    .chart-wrapper {
        position: relative;
        width: 100%;
        height: 500px;  /* Increase height to 500px or more */
        max-width: 900px; /* Optional max width */
        margin: 0 auto; /* Center horizontally */
    }
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
        <div class="chart-container">
            <div class="chart-wrapper">
                <canvas id="dashboardChart"></canvas>
            </div>
        </div>
    </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const chartData = {!! json_encode($chartData) !!};
    const ctx = document.getElementById('dashboardChart').getContext('2d');

    // Define gradient helper function
    function createGradient(ctx, colorStart, colorEnd) {
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, colorStart);
        gradient.addColorStop(1, colorEnd);
        return gradient;
    }

    // Generate gradients for each dataset based on label
    const backgroundColors = chartData.datasets.map(ds => {
        if (ds.label.toLowerCase().includes('paiements')) {
            return createGradient(ctx, 'rgba(59, 130, 246, 0.9)', 'rgba(59, 130, 246, 0.5)');
        } else if (ds.label.toLowerCase() == 'Total Charges') {
            return createGradient(ctx, '#ff9d00f', '#ff9d00f');
        }
         else if (ds.label.toLowerCase() == 'Charges Payées') {
            return createGradient(ctx, '#44ef52ff)', '#2b7131ff');
        }
        else if (ds.label.toLowerCase() == 'Charges Dues') {
            return createGradient(ctx, 'rgba(239, 68, 68, 0.9)', 'rgba(239, 68, 68, 0.5)');
        }

        return ds.backgroundColor || 'rgba(100, 100, 100, 0.7)';
    });

    const dashboardChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: chartData.datasets.map((ds, i) => ({
                ...ds,
                backgroundColor: backgroundColors[i],
                borderColor: 'rgba(0,0,0,0.1)',
                borderWidth: 1,
                borderRadius: 10,
                categoryPercentage: 0.5,  // 👈 spacing between groups
                barPercentage: 0.4,       // 👈 width of bars
                hoverBackgroundColor: 'rgba(0,0,0,0.15)',
                hoverBorderColor: 'rgba(0,0,0,0.3)',
            }))
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 800,
                easing: 'easeOutQuart'
            },
            interaction: {
                mode: 'nearest',
                intersect: false,
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Montant (DH)',
                        color: '#1e293b',
                        font: { size: 16, weight: '600' }
                    },
                    ticks: {
                        color: '#475569',
                        font: { size: 13 },
                        callback: value => value.toLocaleString() + ' DH'
                    },
                    grid: {
                        color: '#e2e8f0',
                        borderDash: [3, 3],
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#475569',
                        font: { size: 14, weight: '600' },
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#334155',
                        font: { size: 15, weight: '600' },
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'rectRounded',
                        boxWidth: 20,
                        boxHeight: 10,
                    }
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: 'rgba(51, 65, 85, 0.9)',
                    titleFont: { size: 16, weight: '700' },
                    bodyFont: { size: 14 },
                    padding: 10,
                    callbacks: {
                        label: ctx => {
                            const val = ctx.parsed.y ?? ctx.parsed;
                            return ctx.dataset.label + ': ' + val.toLocaleString() + ' DH';
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Analyse mensuelle des paiements et charges (DH)',
                    color: '#0f172a',
                    font: { size: 22, weight: '700' },
                    padding: { top: 10, bottom: 30 }
                }
            }
        }
    });
</script>

@endsection