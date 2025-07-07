@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<style>
    .custom-box {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        padding: 20px;
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
        font-size: 34px;
        position: absolute;
        top: 20px;
        right: 20px;
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

    @media (max-width: 768px) {
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
</style>

<div class="container">

    <!-- Formulaire de sélection du mois via <select> -->
    <form method="GET" action="{{ route('dashboard') }}" class="mb-4">
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

    <!-- Reste du contenu inchangé : chiffres, stats, Livewire, etc. -->
    
<div class="custom-box border-green">
    <div class="inner">
        <h3>{{ number_format($totalPaiements, 2, ',', ' ') }} DH</h3>
        <p>Total Paiements</p>
    </div>
    <div class="icon icon-green">
        <i class="fas fa-coins"></i>
    </div>
</div>

<div class="custom-box border-red">
    <div class="inner">
        <h3>{{ number_format($totalCharges, 2, ',', ' ') }} DH</h3>
        <p>Total Charges</p>
    </div>
    <div class="icon icon-red">
        <i class="fas fa-file-invoice-dollar"></i>
    </div>
</div>

<div class="custom-box border-orange">
    <div class="inner">
        <h3>{{ number_format($totalSalaires, 2, ',', ' ') }} DH</h3>
        <p>Total Salaires</p>
    </div>
    <div class="icon icon-orange">
        <i class="fas fa-wallet"></i>
    </div>
</div>

<div class="custom-box border-blue">
    <div class="inner">
        <h3>{{ number_format($chiffreAffairesNet, 2, ',', ' ') }} DH</h3>
        <p>Chiffre d'affaires net</p>
    </div>
    <div class="icon icon-blue">
        <i class="fas fa-calculator"></i>
    </div>
</div>

<div class="custom-box border-teal">
    <div class="inner">
        <h3>{{ number_format($caisseDisponible, 2, ',', ' ') }} DH</h3>
        <p>Caisse disponible</p>
    </div>
    <div class="icon icon-teal">
        <i class="fas fa-wallet"></i>
    </div>
</div>


    <!-- Statistiques générales -->
    <div class="row justify-content-center">
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <div class="custom-box border-orange">
                <div class="inner">
                    <h3>{{ $nbImmeubles }}</h3>
                    <p>Immeubles</p>
                </div>
                <div class="icon icon-orange">
                    <i class="fas fa-building"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <div class="custom-box border-purple">
                <div class="inner">
                    <h3>{{ $nbResidences }}</h3>
                    <p>Résidences</p>
                </div>
                <div class="icon icon-purple">
                    <i class="fas fa-city"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <div class="custom-box border-teal">
                <div class="inner">
                    <h3>{{ $nbAppartements }}</h3>
                    <p>Appartements</p>
                </div>
                <div class="icon icon-teal">
                    <i class="fas fa-home"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <div class="custom-box border-gray">
                <div class="inner">
                    <h3>{{ $nbEmployes }}</h3>
                    <p>Employés</p>
                </div>
                <div class="icon icon-gray">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Composant Livewire -->
    <div class="row mt-4">
        <div class="col-12">
            @livewire('dashboard-chart')
        </div>
    </div>

</div>
@endsection