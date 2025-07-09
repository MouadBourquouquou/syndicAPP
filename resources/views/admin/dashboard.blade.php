@extends('layouts.admin')

@section('title', 'Dashboard Admin')

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

    .icon-red { color: #e74c3c; }
    .icon-green { color: #27ae60; }
    .icon-blue { color: #3498db; }
    .icon-purple { color: #9b59b6; }
    .icon-orange { color: #f39c12; }
    .icon-teal { color: #1abc9c; }
    .icon-gray { color: #7f8c8d; }

</style>

<div class="container mt-5">
    <h1 class="mb-4">Bienvenue, Administrateur</h1>

    <div class="row">
        <!-- Syndics -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <div class="custom-box border-blue">
                <div class="inner">
                    <h3>{{ $nbSyndics }}</h3>
                    <p>Syndics</p>
                </div>
                <div class="icon icon-blue">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>
        </div>

        <!-- Administrateurs -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <div class="custom-box border-purple">
                <div class="inner">
                    <h3>{{ $nbAdmins }}</h3>
                    <p>Administrateurs</p>
                </div>
                <div class="icon icon-purple">
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>
        </div>

        <!-- Résidences -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <div class="custom-box border-orange">
                <div class="inner">
                    <h3>{{ $nbResidences }}</h3>
                    <p>Résidences</p>
                </div>
                <div class="icon icon-orange">
                    <i class="fas fa-city"></i>
                </div>
            </div>
        </div>

        <!-- Immeubles -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <div class="custom-box border-red">
                <div class="inner">
                    <h3>{{ $nbImmeubles }}</h3>
                    <p>Immeubles</p>
                </div>
                <div class="icon icon-red">
                    <i class="fas fa-building"></i>
                </div>
            </div>
        </div>

        <!-- Appartements -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <div class="custom-box border-teal">
                <div class="inner">
                    <h3>{{ $nbAppartements }}</h3>
                    <p>Appartements</p>
                </div>
                <div class="icon icon-teal">
                    <i class="fas fa-door-open"></i>
                </div>
            </div>
        </div>

        <!-- Employés -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <div class="custom-box border-gray">
                <div class="inner">
                    <h3>{{ $nbEmployes }}</h3>
                    <p>Employés</p>
                </div>
                <div class="icon icon-gray">
                    <i class="fas fa-users-cog"></i>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
