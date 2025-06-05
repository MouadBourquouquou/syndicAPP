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

                <div class="card-field">
                    <strong>Dernier mois payé</strong>
                    @if($appartement->dernier_mois_paye)
                        <span class="badge">
                            {{ \Carbon\Carbon::parse($appartement->dernier_mois_paye)->locale('fr_FR')->translatedFormat('F Y') }}
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
                    <span>{{ $appartement->email ?? '-' }}</span>
                </div>
            </div>

            <div class="actions">
                <!-- Voir détails -->
                <button type="button" class="btn btn-view" data-bs-toggle="modal" data-bs-target="#modalAppartement{{ $appartement->id }}">
                    👁 Voir
                </button>

                <!-- Modifier avec modal -->
<button type="button" class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $appartement->id }}">
    ✏️ Modifier
</button>


                <!-- Supprimer -->
                <form action="{{ route('appartements.destroy', $appartement->id_A) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet appartement ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete">🗑 Supprimer</button>
                </form>
            </div>
        </div>

        <!-- Modal Voir -->
        <div class="modal fade" id="modalAppartement{{ $appartement->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $appartement->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel{{ $appartement->id }}">Détails de l'appartement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
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
                            <div class="row"><div class="col-md-6"><strong>Email :</strong></div><div class="col-md-6">{{ $appartement->email ?? '-' }}</div></div>
                            <div class="row"><div class="col-md-6"><strong>Créé le :</strong></div><div class="col-md-6">{{ $appartement->created_at->format('d/m/Y H:i') }}</div></div>
                            <div class="row"><div class="col-md-6"><strong>Modifié le :</strong></div><div class="col-md-6">{{ $appartement->updated_at->format('d/m/Y H:i') }}</div></div>
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

        <!-- Modal Paiement -->
        <div class="modal fade" id="modalPaiement{{ $appartement->id }}" tabindex="-1" aria-labelledby="modalPaiementLabel{{ $appartement->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('paiements.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="appartement_id" value="{{ $appartement->id }}">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalPaiementLabel{{ $appartement->id }}">Ajouter un paiement</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="montant{{ $appartement->id }}" class="form-label">Montant payé (MAD)</label>
                                <input type="number" name="montant" id="montant{{ $appartement->id }}" class="form-control" required step="0.01">
                            </div>
                            <div class="mb-3">
                                <label for="mois_paye{{ $appartement->id }}" class="form-label">Mois payé</label>
                                <input type="date" name="mois_paye" id="mois_paye{{ $appartement->id }}" class="form-control" required>
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
        <!-- Modal Modifier -->
<div class="modal fade" id="modalEdit{{ $appartement->id }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $appartement->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="{{ route('appartements.update', $appartement->id_A) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel{{ $appartement->id }}">Modifier l'appartement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nom</label>
                            <input type="text" name="Nom" class="form-control" value="{{ $appartement->Nom }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Prénom</label>
                            <input type="text" name="Prenom" class="form-control" value="{{ $appartement->Prenom }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Téléphone</label>
                            <input type="text" name="telephone" class="form-control" value="{{ $appartement->telephone }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $appartement->email }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Surface (m²)</label>
                            <input type="number" name="surface" class="form-control" value="{{ $appartement->surface }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Montant cotisation (MAD)</label>
                            <input type="number" name="montant_cotisation_mensuelle" class="form-control" value="{{ $appartement->montant_cotisation_mensuelle }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">CIN</label>
                            <input type="text" name="CIN_A" class="form-control" value="{{ $appartement->CIN_A }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Dernier mois payé</label>
                            <input type="date" name="dernier_mois_paye" class="form-control" value="{{ $appartement->dernier_mois_paye }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">💾 Enregistrer</button>
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
