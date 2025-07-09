@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

<style>
    .custom-box {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.08);
        padding: 28px;
        height: 100%;
        position: relative;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .custom-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        pointer-events: none;
    }

    .custom-box:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 48px rgba(0,0,0,0.12);
    }

    .custom-box .inner h3 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 8px;
        color: #1a1a1a;
        background: linear-gradient(135deg, #1a1a1a 0%, #4a4a4a 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .custom-box .inner p {
        font-size: 16px;
        font-weight: 500;
        color: #6b7280;
        margin: 0;
        letter-spacing: 0.5px;
    }

    .custom-box .icon {
        font-size: 40px;
        position: absolute;
        top: 28px;
        right: 28px;
        opacity: 0.9;
        transition: all 0.3s ease;
    }

    .custom-box:hover .icon {
        transform: scale(1.1);
        opacity: 1;
    }

    .border-red { 
        border-left: 6px solid #ef4444; 
        background: linear-gradient(135deg, #fef2f2 0%, #ffffff 100%);
    }
    .border-green { 
        border-left: 6px solid #10b981; 
        background: linear-gradient(135deg, #ecfdf5 0%, #ffffff 100%);
    }
    .border-blue { 
        border-left: 6px solid #3b82f6; 
        background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
    }
    .border-purple { 
        border-left: 6px solid #8b5cf6; 
        background: linear-gradient(135deg, #f3f4f6 0%, #ffffff 100%);
    }
    .border-orange { 
        border-left: 6px solid #f59e0b; 
        background: linear-gradient(135deg, #fffbeb 0%, #ffffff 100%);
    }
    .border-teal { 
        border-left: 6px solid #14b8a6; 
        background: linear-gradient(135deg, #f0fdfa 0%, #ffffff 100%);
    }
    .border-gray { 
        border-left: 6px solid #6b7280; 
        background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
    }

    .icon-red { 
        color: #ef4444; 
        filter: drop-shadow(0 4px 8px rgba(239, 68, 68, 0.3));
    }
    .icon-green { 
        color: #10b981; 
        filter: drop-shadow(0 4px 8px rgba(16, 185, 129, 0.3));
    }
    .icon-blue { 
        color: #3b82f6; 
        filter: drop-shadow(0 4px 8px rgba(59, 130, 246, 0.3));
    }
    .icon-purple { 
        color: #8b5cf6; 
        filter: drop-shadow(0 4px 8px rgba(139, 92, 246, 0.3));
    }
    .icon-orange { 
        color: #f59e0b; 
        filter: drop-shadow(0 4px 8px rgba(245, 158, 11, 0.3));
    }
    .icon-teal { 
        color: #14b8a6; 
        filter: drop-shadow(0 4px 8px rgba(20, 184, 166, 0.3));
    }
    .icon-gray { 
        color: #6b7280; 
        filter: drop-shadow(0 4px 8px rgba(107, 114, 128, 0.3));
    }

    .container {
        max-width: 1200px;
    }

    h1 {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 2rem;
        background: linear-gradient(135deg, #1f2937 0%, #4b5563 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .row {
        gap: 0;
    }

    [class*="col-"] {
        padding: 0 12px;
    }

    @media (max-width: 768px) {
        .custom-box {
            padding: 24px;
        }
        
        .custom-box .inner h3 {
            font-size: 28px;
        }
        
        .custom-box .icon {
            font-size: 36px;
            top: 24px;
            right: 24px;
        }
        
        h1 {
            font-size: 2rem;
        }
    }
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