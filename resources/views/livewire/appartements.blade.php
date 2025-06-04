@extends('layouts.app')

@section('title', 'Liste des appartements')

@push('styles')
<style>
    .card-appartement {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        font-size: 0.875rem;
    }
    .card-appartement h5 {
        font-size: 1rem;
        margin-bottom: 10px;
        color: #1f2937;
    }
    /* Affichage vertical des données, une donnée par ligne */
    .card-appartement .card-body {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .card-field {
        margin-bottom: 8px;
    }
    .card-field strong {
        display: block;
        color: #6b7280;
        font-size: 0.8rem;
    }
    .card-field span {
        display: block;
        font-size: 0.9rem;
    }
    .badge {
        font-size: 0.75rem;
        padding: 5px 8px;
        border-radius: 12px;
        color: white;
        background-color: #10b981;
    }
    .actions {
        margin-top: 15px;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .btn {
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 500;
        color: white;
        border: none;
        cursor: pointer;
    }
    .btn-view { background-color: #111827; }
    .btn-edit { background-color: #3b82f6; }
    .btn-delete { background-color: #ef4444; }
    .btn:hover { opacity: 0.85; }
</style>
@endpush

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Liste des appartements</h4>

    @forelse ($appartements as $appartement)
        <div class="card-appartement">
            <h5>{{ $appartement->immeuble->nom ?? 'Immeuble inconnu' }} - Appartement {{ $appartement->numero }}</h5>
            
            <div class="card-body">
                <div class="card-field">
                    <strong>Nom</strong>
                    <span>{{ $appartement->Nom }} {{ $appartement->Prenom }}</span>
                </div>
                
                <div class="card-field" style="display: flex; align-items: center; gap: 6px;">
    <strong style="font-weight: 600; font-size: 0.85rem; color: #374151;">Dernier mois payé :</strong>
    @if($appartement->dernier_mois_paye)
        <span style="background-color: #4ade80; color: #065f46; padding: 3px 8px; border-radius: 9999px; font-size: 0.75rem; font-weight: 500;">
            {{ \Carbon\Carbon::parse($appartement->dernier_mois_paye)->locale('fr_FR')->translatedFormat('M Y') }}
        </span>
    @else
        <em style="color: #9ca3af; font-size: 0.75rem;">Non renseigné</em>
    @endif
</div>

                
                <div class="card-field">
                    <strong>Téléphone</strong>
                    <span>{{ $appartement->telephone ?? '-' }}</span>
                </div>
                
                <div class="card-field">
                    <strong>Email</strong>
                    <span>{{ $appartement->email }}</span>
                </div>
            </div>

            <div class="actions">
                <!-- Voir -->
                <button type="button" class="btn btn-view" data-bs-toggle="modal" data-bs-target="#modalAppartement{{ $appartement->id }}">
                    👁 Voir
                </button>

                <!-- Modifier -->
                <a href="{{ route('appartement.edit', $appartement) }}" class="btn btn-edit">✏️ Modifier</a>

                <!-- Supprimer -->
                <form action="{{ route('appartement.destroy', $appartement) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Voulez-vous vraiment supprimer cet appartement ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete">🗑 Supprimer</button>
                </form>
            </div>
        </div>

        {{-- Modal Voir Détails --}}
        <div class="modal fade" id="modalAppartement{{ $appartement->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $appartement->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel{{ $appartement->id }}">Détails de l'appartement</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row"><div class="col-md-6"><strong>Numéro :</strong></div><div class="col-md-6">{{ $appartement->numero }}</div></div>
                            <div class="row"><div class="col-md-6"><strong>Immeuble :</strong></div><div class="col-md-6">{{ $appartement->immeuble->nom ?? 'Inconnu' }}</div></div>
                            <div class="row"><div class="col-md-6"><strong>Nom :</strong></div><div class="col-md-6">{{ $appartement->Nom }}</div></div>
                            <div class="row"><div class="col-md-6"><strong>Prénom :</strong></div><div class="col-md-6">{{ $appartement->Prenom }}</div></div>
                            <div class="row"><div class="col-md-6"><strong>CIN :</strong></div><div class="col-md-6">{{ $appartement->CIN_A }}</div></div>
                            <div class="row"><div class="col-md-6"><strong>Surface :</strong></div><div class="col-md-6">{{ $appartement->surface }} m²</div></div>
                            <div class="row"><div class="col-md-6"><strong>Montant cotisation :</strong></div><div class="col-md-6">{{ $appartement->montant_cotisation_mensuelle }} MAD</div></div>
                            <div class="row"><div class="col-md-6"><strong>Dernier mois payé :</strong></div>
                                <div class="col-md-6">
                                    @if($appartement->dernier_mois_paye)
                                        {{ \Carbon\Carbon::parse($appartement->dernier_mois_paye)->locale('fr_FR')->translatedFormat('F Y') }}
                                    @else
                                        Non renseigné
                                    @endif
                                </div>
                            </div>
                            <div class="row"><div class="col-md-6"><strong>Téléphone :</strong></div><div class="col-md-6">{{ $appartement->telephone ?? '-' }}</div></div>
                            <div class="row"><div class="col-md-6"><strong>Créé le :</strong></div><div class="col-md-6">{{ $appartement->created_at->format('d/m/Y H:i') }}</div></div>
                            <div class="row"><div class="col-md-6"><strong>Dernière modification :</strong></div><div class="col-md-6">{{ $appartement->updated_at->format('d/m/Y H:i') }}</div></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalPaiement{{ $appartement->id }}">
                            💳 Ajouter un paiement
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Paiement --}}
        <div class="modal fade" id="modalPaiement{{ $appartement->id }}" tabindex="-1" aria-labelledby="modalPaiementLabel{{ $appartement->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('paiements.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="appartement_id" value="{{ $appartement->id_A }}">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalPaiementLabel{{ $appartement->id_A }}">Ajouter un paiement</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="montant{{ $appartement->id_A }}" class="form-label">Montant payé (MAD)</label>
                                <input type="number" name="montant" class="form-control" id="montant{{ $appartement->id_A }}" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="mois_paye{{ $appartement->id_A}}" class="form-label">Mois payé</label>
                                <input type="date" name="mois_paye" class="form-control" id="mois_paye{{ $appartement->id_A }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Valider le paiement</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p>Aucun appartement trouvé.</p>
    @endforelse

    <div class="mt-3">
        {{ $appartements->links() }}
    </div>
</div>
@endsection
