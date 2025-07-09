@extends('layouts.admin')

@section('title', 'Détail du Syndic')

@section('content')

<style>
    .page-container {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
    }

    .content-wrapper {
        max-width: 1200px;
        padding: 0 1rem;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 900;
        color: #0f172a;
        margin-bottom: 2rem;
        text-align: center;
        background: linear-gradient(135deg, #0f172a 0%, #334155 50%, #64748b 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 4px 8px rgba(0,0,0,0.1);
        position: relative;
    }

    .page-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 120px;
        height: 4px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        border-radius: 2px;
    }

    .modern-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04);
        border: none;
        overflow: hidden;
        transition: all 0.3s ease;
        margin-bottom: 2rem;
    }

    .modern-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12), 0 5px 15px rgba(0,0,0,0.08);
    }

    .card-header {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        color: white;
        padding: 1.5rem;
        font-weight: 700;
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        position: relative;
    }

    .card-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    }

    .card-body {
        padding: 2rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 0;
    }

    .info-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 12px;
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }

    .info-item:hover {
        transform: translateX(5px);
        border-left-color: #3b82f6;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
    }

    .info-label {
        font-weight: 700;
        color: #1e293b;
        margin-right: 1rem;
        min-width: 120px;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        color: #334155;
        font-weight: 500;
        font-size: 1rem;
        flex: 1;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1e293b;
        position: relative;
    }

    .section-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        border-radius: 2px;
    }

    .modern-list {
        display: grid;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .list-item {
        background: #ffffff;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .list-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(135deg, #10b981, #059669);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .list-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        border-color: #3b82f6;
    }

    .list-item:hover::before {
        transform: scaleX(1);
    }

    .list-item-title {
        font-weight: 700;
        color: #1e293b;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }

    .list-item-subtitle {
        color: #64748b;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .list-item-meta {
        color: #94a3b8;
        font-size: 0.9rem;
        font-style: italic;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        margin: 2rem 0;
    }

    .empty-state-icon {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }

    .empty-state p {
        font-size: 1.25rem;
        color: #64748b;
        font-weight: 600;
        margin: 0;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
        margin-top: 2rem;
    }

    .back-btn:hover {
        background: linear-gradient(135deg, #4b5563, #374151);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(107, 114, 128, 0.4);
        color: white;
        text-decoration: none;
    }

    .back-btn::before {
        content: '←';
        font-size: 1.2rem;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .info-item {
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }
        
        .info-label {
            margin-right: 0;
            margin-bottom: 0.5rem;
            min-width: auto;
        }
        
        .section-title {
            font-size: 1.25rem;
            margin: 2rem 0 1rem 0;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .list-item {
            padding: 1rem;
        }
    }
</style>

<div class="page-container">
    <div class="w-full px-4">
        <h2 class="page-title">Détails du Syndic</h2>

        <!-- Info syndic -->
        <div class="modern-card">
            <div class="card-header">
                Informations du Syndic
            </div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">ID :</span>
                        <span class="info-value">{{ $syndic->id }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Nom :</span>
                        <span class="info-value">{{ $syndic->name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Prénom :</span>
                        <span class="info-value">{{ $syndic->prenom }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email :</span>
                        <span class="info-value">{{ $syndic->email }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Statut :</span>
                        <span class="info-value">{{ $syndic->statut }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Société :</span>
                        <span class="info-value">{{ $syndic->nom_societé ?? '---' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Adresse :</span>
                        <span class="info-value">{{ $syndic->adresse }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Téléphone :</span>
                        <span class="info-value">{{ $syndic->tel }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Fax :</span>
                        <span class="info-value">{{ $syndic->Fax ?? '---' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Ville :</span>
                        <span class="info-value">{{ $syndic->ville }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Résidences -->
        <h4 class="section-title">Résidences gérées</h4>
        @if ($residences->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">🏢</div>
                <p>Aucune résidence trouvée.</p>
            </div>
        @else
            <div class="modern-list">
                @foreach ($residences as $residence)
                    <div class="list-item">
                        <div class="list-item-title">{{ $residence->nom }}</div>
                        <div class="list-item-subtitle">{{ $residence->ville }}</div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Immeubles -->
        <h4 class="section-title">Immeubles associés</h4>
        @if ($immeubles->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">🏠</div>
                <p>Aucun immeuble trouvé.</p>
            </div>
        @else
            <div class="modern-list">
                @foreach ($immeubles as $immeuble)
                    <div class="list-item">
                        <div class="list-item-title">{{ $immeuble->nom }}</div>
                        <div class="list-item-subtitle">{{ $immeuble->ville }}</div>
                        @if($immeuble->residence)
                            <div class="list-item-meta">Résidence : {{ $immeuble->residence->nom }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <a href="{{ route('admin.syndics') }}" class="back-btn">Retour</a>
    </div>
</div>

@endsection     