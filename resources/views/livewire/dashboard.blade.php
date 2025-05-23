
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
        </div>
    </div>
</div>

<!-- Graphique avec Livewire -->
<div class="row mt-4">
    <div class="col-12">
        @livewire('dashboard-chart')
    </div>
</div>
@endsection

