@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Immeubles -->
    <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>10</h3>
                <p>Immeubles</p>
            </div>
            <div class="icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="small-box-footer p-2 d-flex justify-content-between align-items-center">
                <a href="{{ route('immeubles.ajouter') }}" class="btn btn-sm btn-light flex-fill mx-1">
                    <i class="fas fa-plus"></i> Ajouter
                </a>
                <a href="{{ route('immeubles') }}" class="btn btn-sm btn-light flex-fill mx-1">
                    <i class="fas fa-eye"></i> Afficher
                </a>
            </div>
        </div>
    </div>

    <!-- Appartements -->
    <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>45</h3>
                <p>Appartements</p>
            </div>
            <div class="icon">
                <i class="fas fa-home"></i>
            </div>
            <div class="small-box-footer p-2 d-flex justify-content-between align-items-center">
                <a href="{{ route('appartements.ajouter') }}" class="btn btn-sm btn-light flex-fill mx-1">
                    <i class="fas fa-plus"></i> Ajouter
                </a>
                <a href="{{ route('appartements') }}" class="btn btn-sm btn-light flex-fill mx-1">
                    <i class="fas fa-eye"></i> Afficher
                </a>
            </div>
        </div>
    </div>

    <!-- Employés -->
    <div class="col-lg-4 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>8</h3>
                <p>Employés</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="small-box-footer p-2 d-flex justify-content-between align-items-center">
                <a href="{{ route('employes.ajouter') }}" class="btn btn-sm btn-light flex-fill mx-1">
                    <i class="fas fa-plus"></i> Ajouter
                </a>
                <a href="{{ route('employes') }}" class="btn btn-sm btn-light flex-fill mx-1">
                    <i class="fas fa-eye"></i> Afficher
                </a>
            </div>
        </div>
    </div>
</div>
@endsection