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
