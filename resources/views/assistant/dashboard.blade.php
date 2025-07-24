@php
    $layout = auth()->user()->statut === 'assistant_syndic' ? 'assistant.layouts.app' : 'layouts.app';
@endphp

@extends($layout)

@section('title', 'Dashboard')

@section('content')

<style>
    /* Container & layout */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 15px;
        min-height: 650px;
    }

    /* Dashboard header */
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

    /* Chart container */
    .chart-container {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 4px 24px rgba(0, 0, 0, 0.08);
        border: 1px solid #e2e8f0;
        padding: 10px;
        position: relative;
        overflow: hidden;
        margin-top: 40px;
        margin-bottom: 40px;
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

    /* Chart wrapper */
    .chart-wrapper {
        position: relative;
        height: 600px;
        max-width: 900px;
        margin: 0 auto;
    }

    #dashboardChart {
        width: 100% !important;
        height: 100% !important;

    }

    /* Stats cards */
    .dashboard-stats {
        margin-left: -0.75rem;
        margin-right: -0.75rem;
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        justify-content: center;
    }

    .dashboard-card {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        padding: 18px;
        flex: 1 1 240px;
        max-width: 280px;
        position: relative;
        color: #343a40;
        border-left: 5px solid transparent;
    }

    .dashboard-card .price {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 6px;
        color: #1e293b;
    }

    .dashboard-card .inner p {
        font-size: 16px;
        color: #6c757d;
        margin: 0;
    }

    .dashboard-card .icon {
        font-size: 30px;
        position: absolute;
        top: 20px;
        right: 20px;
        opacity: 0.3;
    }

    /* Border colors */
    .border-red { border-left-color: #e74c3c; }
    .border-green { border-left-color: #27ae60; }
    .border-blue { border-left-color: #3498db; }
    .border-purple { border-left-color: #9b59b6; }
    .border-orange { border-left-color: #f39c12; }
    .border-teal { border-left-color: #1abc9c; }
    .border-gray { border-left-color: #7f8c8d; }

    /* Icon colors */
    .icon-red { color: #e74c3c; }
    .icon-green { color: #27ae60; }
    .icon-blue { color: #3498db; }
    .icon-purple { color: #9b59b6; }
    .icon-orange { color: #f39c12; }
    .icon-teal { color: #1abc9c; }
    .icon-gray { color: #7f8c8d; }

    /* Form styling */
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
        cursor: pointer;
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

    /* Responsive tweaks */
    @media (max-width: 768px) {
        .chart-wrapper {
            height: 450px !important;
        }

        .dashboard-card {
            max-width: 100%;
        }
    }

    @media (max-width: 480px) {
        .chart-wrapper {
            height: 350px !important;
        }
    }
</style>

<div class="container">
    <!-- Month selection form -->
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

    <!-- Statistics cards -->
    <div class="dashboard-stats">
        <div class="dashboard-card border-green">
            <p class="price">{{ number_format($totalPaiements, 2, ',', ' ') }} DH</p>
            <div class="inner"><p>Total Paiements</p></div>
            <div class="icon icon-green"><i class="fas fa-coins"></i></div>
        </div>
        <div class="dashboard-card border-red">
            <p class="price">{{ number_format($totalCharges, 2, ',', ' ') }} DH</p>
            <div class="inner"><p>Total Charges</p></div>
            <div class="icon icon-red"><i class="fas fa-file-invoice-dollar"></i></div>
        </div>
        <div class="dashboard-card border-orange">
            <p class="price">{{ number_format($totalSalaires, 2, ',', ' ') }} DH</p>
            <div class="inner"><p>Total Salaires</p></div>
            <div class="icon icon-orange"><i class="fas fa-wallet"></i></div>
        </div>
        <div class="dashboard-card border-blue">
            <p class="price">{{ number_format($chiffreAffairesNet, 2, ',', ' ') }} DH</p>
            <div class="inner"><p>Chiffre d'affaires net</p></div>
            <div class="icon icon-blue"><i class="fas fa-calculator"></i></div>
        </div>
        <div class="dashboard-card border-teal">
            <p class="price">{{ number_format($caisseDisponible, 2, ',', ' ') }} DH</p>
            <div class="inner"><p>Caisse disponible</p></div>
            <div class="icon icon-teal"><i class="fas fa-wallet"></i></div>
        </div>
        <div class="dashboard-card border-orange">
            <p class="price">{{ $nbImmeubles }}</p>
            <div class="inner"><p>Immeubles</p></div>
            <div class="icon icon-orange"><i class="fas fa-building"></i></div>
        </div>
        <div class="dashboard-card border-purple">
            <p class="price">{{ $nbResidences }}</p>
            <div class="inner"><p>Résidences</p></div>
            <div class="icon icon-purple"><i class="fas fa-city"></i></div>
        </div>
        <div class="dashboard-card border-teal">
            <p class="price">{{ $nbAppartements }}</p>
            <div class="inner"><p>Appartements</p></div>
            <div class="icon icon-teal"><i class="fas fa-home"></i></div>
        </div>
        <div class="dashboard-card border-gray">
            <p class="price">{{ $nbEmployes }}</p>
            <div class="inner"><p>Employés</p></div>
            <div class="icon icon-gray"><i class="fas fa-users"></i></div>
        </div>
    </div>

    <!-- Chart section -->
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

    // Create vertical gradient
    function createGradient(ctx, colorStart, colorEnd) {
        const gradient = ctx.createLinearGradient(0, 0, 0, 600);
        gradient.addColorStop(0, colorStart);
        gradient.addColorStop(1, colorEnd);
        return gradient;
    }

    // Assign gradients dynamically based on dataset labels
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

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: chartData.datasets.map((ds, i) => ({
                ...ds,
                backgroundColor: backgroundColors[i],
                borderColor: 'rgba(0,0,0,0.1)',
                borderWidth: 1,
                borderRadius: 10,
                categoryPercentage: 0.5,
                barPercentage: 0.4,       
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
