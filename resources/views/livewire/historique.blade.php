@php
    $layout = auth()->user()->statut === 'assistant_syndic' ? 'assistant.layouts.app' : 'layouts.app';
@endphp

@extends($layout)

@section('title', 'Historique des Paiements')

@push('styles')
<style>
    /* Style repris du design moderne */
    .card-employe {
        border: none;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08), 0 2px 4px rgba(0,0,0,0.05);
        font-size: 0.875rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .card-employe::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6, #06b6d4, #10b981);
        background-size: 200% 100%;
        animation: shimmer 3s ease-in-out infinite;
    }

    .card-employe:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12), 0 4px 8px rgba(0,0,0,0.08);
    }

    .card-employe h5 {
        font-size: 1.25rem;
        margin-bottom: 16px;
        color: #1f2937;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .card-employe table {
        width: 100%;
    }

    .card-employe td {
        padding: 8px 12px;
        vertical-align: top;
        border-bottom: 1px solid #f1f5f9;
    }

    .card-employe td:first-child {
        font-weight: 600;
        color: #475569;
        width: 40%;
    }

    .card-employe td:last-child {
        color: #64748b;
    }

    /* Filter buttons */
    .filter-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 32px;
        justify-content: center;
    }

    .btn-filter {
        padding: 12px 24px;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 600;
        color: white;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-filter::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-filter:hover::before {
        left: 100%;
    }

    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        color: white;
        text-decoration: none;
    }

    .btn-filter.active {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }

    .btn-success { 
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-warning { 
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .btn-danger { 
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-secondary { 
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
    }

    /* Badge styles */
    .badge-month {
        display: inline-block;
        padding: 6px 12px;
        margin: 2px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        color: white;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
        transition: all 0.3s ease;
    }

    .badge-month:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .months-container {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        margin-top: 4px;
    }

    /* Amount styling */
    .amount {
        font-size: 1.1rem;
        font-weight: 700;
        color: #059669;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Container and header */
    .container {
        max-width: 1200px;
    }

    h1 {
        color: #1f2937;
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 32px;
        text-align: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        margin-top: 40px;
    }

    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .empty-state h3 {
        color: #6b7280;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .empty-state p {
        color: #9ca3af;
        margin: 0;
    }

    /* Status indicators */
    .status-complet {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .status-incomplet {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .status-retard {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    /* Animations */
    @keyframes shimmer {
        0% {
            background-position: -200% 0;
        }
        100% {
            background-position: 200% 0;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card-employe {
        animation: fadeIn 0.5s ease-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-employe {
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .filter-buttons {
            flex-direction: column;
            align-items: center;
        }
        
        .btn-filter {
            width: 100%;
            max-width: 200px;
            justify-content: center;
        }
        
        h1 {
            font-size: 1.5rem;
        }

        .months-container {
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Historique des Paiements</h1>

   

    @forelse ($paiements as $index => $paiement)
        <div class="card-employe" style="animation-delay: {{ $index * 0.1 }}s">
            <h5>
                Appartement {{ $paiement->appartement->numero ?? 'N/A' }} - 
                {{ $paiement->appartement->immeuble->nom ?? 'Immeuble inconnu' }}
            </h5>

            <table>
                <tr>
                    <td>Appartement</td>
                    <td>{{ $paiement->appartement->numero ?? 'Non défini' }}</td>
                </tr>
                <tr>
                    <td>Immeuble</td>
                    <td>{{ $paiement->appartement->immeuble->nom ?? 'Non défini' }}</td>
                </tr>
                <tr>
                    <td>Résidence</td>
                    <td>{{ $paiement->appartement->immeuble->residence->nom ?? 'Non définie' }}</td>
                </tr>
                <tr>
                    <td>Propriétaire</td>
                    <td>{{ $paiement->appartement->Nom ?? '' }} {{ $paiement->appartement->Prenom ?? '' }}</td>
                </tr>
                <tr>
                    <td>Mois payés</td>
                    <td>
                        <div class="months-container">
                            @php
                                // Fix: Handle both array and JSON string cases
                                $moisPayes = [];
                                if (is_array($paiement->mois_payes)) {
                                    $moisPayes = $paiement->mois_payes;
                                } elseif (is_string($paiement->mois_payes)) {
                                    $moisPayes = json_decode($paiement->mois_payes, true) ?? [];
                                }
                            @endphp
                            @if(count($moisPayes) > 0)
                                @foreach ($moisPayes as $mois)
                                    <span class="badge-month">
                                        {{ \Carbon\Carbon::parse($mois)->locale('fr_FR')->translatedFormat('F Y') }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-muted">Aucun mois payé</span>
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Montant total</td>
                    <td>
                        <span class="amount">{{ number_format($paiement->montant, 2, ',', ' ') }} DH</span>
                    </td>
                </tr>
                <tr>
                    <td>Nombre de mois</td>
                    <td>
                        <span class="badge-month">{{ count($moisPayes) }} mois</span>
                    </td>
                </tr>

            </table>
            <div class="text-center mt-4">
                <a href="{{ route(auth()->user()->statut === 'assistant_syndic' ? 'assistant.paiements.facture' : 'paiements.facture', $paiement->id) }}"
                target="_blank"
                class="btn btn-outline-primary rounded-pill px-4 py-2 shadow-sm">
                    📄 Voir la facture
                </a>
            </div>

        </div>
    @empty
        <div class="empty-state">
            <div class="empty-state-icon">
                @if(request('filtre') == 'complet')
                    ✅
                @elseif(request('filtre') == 'incomplet')
                    ⚠️
                @elseif(request('filtre') == 'retard')
                    🚨
                @else
                    📋
                @endif
            </div>
            <h3>Aucun paiement trouvé</h3>
            <p>
                @if(request('filtre') == 'complet')
                    Aucun appartement n'a payé 12 mois complets.
                @elseif(request('filtre') == 'incomplet')
                    Aucun appartement n'a de paiements incomplets.
                @elseif(request('filtre') == 'retard')
                    Aucun appartement n'est en retard de paiement.
                @else
                    Aucun paiement n'a été enregistré pour le moment.
                @endif
            </p>
        </div>
    @endforelse
</div>
@endsection
