@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="container">
    <!-- Première ligne de boîtes -->
    <div class="row justify-content-center">
        <!-- Immeubles -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $nbImmeubles }}</h3>
                    <p>Immeubles</p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
            </div>
        </div>

        <!-- Appartements -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $nbAppartements }}</h3>
                    <p>Appartements</p>
                </div>
                <div class="icon">
                    <i class="fas fa-home"></i>
                </div>
            </div>
        </div>

        <!-- Employés -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $nbEmployes }}</h3>
                    <p>Employés</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Deuxième ligne de boîtes -->
    <div class="row justify-content-center">
        <!-- Résidences -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $nbResidences }}</h3>
                    <p>Résidences</p>
                </div>
                <div class="icon">
                    <i class="fas fa-city"></i>
                </div>
            </div>
        </div>

        <!-- Chiffre d'affaires -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ number_format($chiffreAffaires, 2, ',', ' ') }} DH</h3>
                    <p>Chiffre d'affaires</p>
                </div>
                <div class="icon">
                    <i class="fas fa-coins"></i>
                </div>
            </div>
        </div>

        <!-- Caisse disponible -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ number_format($caisseDisponible, 2, ',', ' ') }} DH</h3>
                    <p>Caisse disponible (Total)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphique avec Livewire -->
    <div class="row mt-4">
        <div class="col-12">
            @livewire('dashboard-chart')
        </div>
    </div>
</div>

@endsection
 