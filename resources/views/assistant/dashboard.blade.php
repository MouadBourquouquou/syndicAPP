@extends('assistant.layouts.app')

@section('title', 'Dashboard Assistant')

@section('content')

<style>
    .custom-box {
        background: #fff;
        padding: 20px;
        color: #444;
        position: relative;
        border-left: 5px solid;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .1);
        margin-bottom: 20px;
    }

    .custom-box .inner h3 {
        font-size: 28px;
        margin: 0;
        font-weight: bold;
    }

    .custom-box .inner p {
        margin: 5px 0 0;
        font-size: 16px;
    }

    .icon {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 30px;
        opacity: 0.3;
    }

    .border-green { border-color: #28a745; }
    .border-red { border-color: #dc3545; }
    .border-orange { border-color: #fd7e14; }
    .border-blue { border-color: #007bff; }
    .border-teal { border-color: #20c997; }
    .border-purple { border-color: #6f42c1; }
    .border-gray { border-color: #6c757d; }

    .icon-green { color: #28a745; }
        .icon-red { color: #dc3545; }
    .icon-orange { color: #fd7e14; }
    .icon-blue { color: #007bff; }
    .icon-teal { color: #20c997; }
    .icon-purple { color: #6f42c1; }
    .icon-gray { color: #6c757d; }
</style>

<div class="container">

    <!-- 🔹 Formulaire de sélection du mois -->
    <form method="GET" action="{{ route('assistant.dashboard') }}" class="mb-4">
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

    <!-- 🔸 Statistiques financières -->
    <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="custom-box border-green">
                <div class="inner">
                    <h3>{{ number_format($totalPaiements, 2, ',', ' ') }} DH</h3>
                    <p>Total Paiements</p>
                </div>
                <div class="icon icon-green">
                    <i class="fas fa-coins"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="custom-box border-red">
                <div class="inner">
                    <h3>{{ number_format($totalCharges, 2, ',', ' ') }} DH</h3>
                    <p>Total Charges</p>
                </div>
                <div class="icon icon-red">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="custom-box border-orange">
                <div class="inner">
                    <h3>{{ number_format($totalSalaires, 2, ',', ' ') }} DH</h3>
                    <p>Total Salaires</p>
                </div>
                <div class="icon icon-orange">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 mb-4">
            <div class="custom-box border-blue">
                <div class="inner">
                    <h3>{{ number_format($chiffreAffairesNet, 2, ',', ' ') }} DH</h3>
                    <p>Chiffre d'affaires net</p>
                </div>
                <div class="icon icon-blue">
                    <i class="fas fa-calculator"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 mb-4">
            <div class="custom-box border-teal">
                <div class="inner">
                    <h3>{{ number_format($caisseDisponible, 2, ',', ' ') }} DH</h3>
                    <p>Caisse disponible</p>
                </div>
                <div class="icon icon-teal">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔸 Statistiques générales -->
    <div class="row">
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
    </div>

    <!-- 🔹 Graphique -->
    <div class="row mt-4">
        <div class="col-12">
            @livewire('dashboard-chart')
        </div>
    </div>
</div>
@endsection
