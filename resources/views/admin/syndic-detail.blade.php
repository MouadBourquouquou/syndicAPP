@extends('layouts.admin')

@section('title', 'Détail du Syndic')

@section('content')

<style>
    .detail-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 1.5rem;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1.5rem;
        text-align: center;
        position: relative;
        padding-bottom: 0.5rem;
    }

    .page-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: #3b82f6;
        border-radius: 2px;
    }

    .modern-card {
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border: 1px solid #e2e8f0;
        margin-bottom: 1.5rem;
    }

    .card-header {
        background: #1e293b;
        color: white;
        padding: 0.75rem 1rem;
        font-weight: 600;
        font-size: 0.9rem;
        border-radius: 10px 10px 0 0;
    }

    .card-body {
        padding: 0.5rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 0.75rem;
        column-gap: 80px;
    }

    .info-item {
        display: flex;
        align-items: center;
        padding: 0.5rem;
    }

    .info-label {
        font-weight: 600;
        color: #1e293b;
        margin-right: 0px;
        min-width: 80px;
        font-size: 0.85rem;
    }

    .info-value {
        color: #334155;
        font-size: 0.85rem;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
        margin: 1.25rem 0 0.75rem;
        padding-left: 0.5rem;
        border-left: 3px solid #3b82f6;
    }

    .modern-list {
        display: grid;
        gap: 0.5rem;
    }

    .list-item {
        background: #ffffff;
        border-radius: 6px;
        padding: 0.75rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
    }

    .list-item-title {
        font-weight: 600;
        color: #1e293b;
        font-size: 0.9rem;
    }

    .list-item-subtitle {
        color: #64748b;
        font-size: 0.8rem;
    }

    .list-item-meta {
        color: #94a3b8;
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    .empty-state {
        text-align: center;
        padding: 1.5rem;
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        margin: 0.5rem 0;
    }

    .empty-state-icon {
        font-size: 2rem;
        color: #cbd5e1;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        font-size: 0.9rem;
        color: #64748b;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: #4b5563;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.85rem;
        margin-top: 1.5rem;
    }

    .back-btn:hover {
        background: #374151;
        color: white;
    }

    .back-btn::before {
        content: '←';
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .detail-container {
            padding: 1rem;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="detail-container">
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

@endsection