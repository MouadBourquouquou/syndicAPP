@extends('layouts.app')

@section('title', 'Liste des résidences')

@push('styles')
<style>
    .card-residence {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        font-size: 0.875rem;
    }
    .card-residence h5 {
        font-size: 1rem;
        margin-bottom: 10px;
        color: #1f2937;
    }
    .card-residence table {
        width: 100%;
    }
    .card-residence td {
        padding: 6px 8px;
        vertical-align: top;
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
    <h4 class="mb-4">Liste des résidences</h4>

    @forelse ($residences as $residence)
        <div class="card-residence">
            <h5>{{ $residence->nom }}</h5>
            <table>
                <tr><td><strong>Ville :</strong></td><td>{{ $residence->ville }}</td></tr>
                <tr><td><strong>Adresse :</strong></td><td>{{ $residence->adresse }}</td></tr>
                <tr><td><strong>Nombre d’immeubles :</strong></td><td>{{ $residence->nombre_immeubles }}</td></tr>
            </table>

            <div class="actions">
                <button type="button" class="btn btn-view" data-bs-toggle="modal" data-bs-target="#modalResidence{{ $residence->id }}">
                    👁 Voir
                </button>
                <button type="button" class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditResidence{{ $residence->id }}">
                    ✏️ Modifier
                </button>
                <form action="{{ route('residences.destroy', $residence->id) }}" method="POST" onsubmit="return confirm('Supprimer cette résidence ?');" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete">🗑 Supprimer</button>
                </form>
            </div>
        </div>

        <!-- Modal Voir -->
        <div class="modal fade" id="modalResidence{{ $residence->id }}" tabindex="-1" aria-labelledby="modalLabelResidence{{ $residence->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabelResidence{{ $residence->id }}">Détails de la résidence</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-borderless">
                            <tr><th>Nom :</th><td>{{ $residence->nom }}</td></tr>
                            <tr><th>Ville :</th><td>{{ $residence->ville }}</td></tr>
                            <tr><th>Adresse :</th><td>{{ $residence->adresse }}</td></tr>
                            <tr><th>Nombre d’immeubles :</th><td>{{ $residence->nombre_immeubles }}</td></tr>
                            <tr><th>Créé le :</th><td>{{ $residence->created_at->format('d/m/Y H:i') }}</td></tr>
                            <tr><th>Modifié le :</th><td>{{ $residence->updated_at->format('d/m/Y H:i') }}</td></tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Modifier -->
        <div class="modal fade" id="modalEditResidence{{ $residence->id }}" tabindex="-1" aria-labelledby="modalEditLabelResidence{{ $residence->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <form action="{{ route('residences.update', $residence->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditLabelResidence{{ $residence->id }}">
                                Modifier la résidence - <strong>{{ $residence->nom }}</strong>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nomResidence{{ $residence->id }}" class="form-label">Nom</label>
                                    <input type="text" id="nomResidence{{ $residence->id }}" name="nom" class="form-control" value="{{ $residence->nom }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="villeResidence{{ $residence->id }}" class="form-label">Ville</label>
                                    <input type="text" id="villeResidence{{ $residence->id }}" name="ville" class="form-control" value="{{ $residence->ville }}" required>
                                </div>
                                <div class="col-md-12">
                                    <label for="adresseResidence{{ $residence->id }}" class="form-label">Adresse</label>
                                    <input type="text" id="adresseResidence{{ $residence->id }}" name="adresse" class="form-control" value="{{ $residence->adresse }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="nombreImmeubles{{ $residence->id }}" class="form-label">Nombre d’immeubles</label>
                                    <input type="number" id="nombreImmeubles{{ $residence->id }}" name="nombre_immeubles" class="form-control" value="{{ $residence->nombre_immeubles }}" min="0" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer mt-3">
                            <button type="submit" class="btn btn-success">📀 Enregistrer</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p>Aucune résidence trouvée.</p>
    @endforelse
</div>
@endsection
