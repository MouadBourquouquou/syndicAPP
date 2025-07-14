@extends('assistant.layouts.app')

@section('title', 'Dashboard Assistant')

@section('content')

<style>
    /* Your dashboard styles here (copied from syndic dashboard) */
    /* ... you can copy the same styles you shared or keep minimal here */
</style>

<div class="container">

    <!-- Month selection form -->
    <form method="GET" action="{{ route('assistant.dashboard') }}" class="mb-4">
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

    <!-- Dashboard stats boxes -->
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

    <!-- General statistics -->
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

    <!-- Livewire chart -->
    <div class="row mt-4">
        <div class="col-12">
            @livewire('dashboard-chart')
        </div>
    </div>

</div>
@endsection
