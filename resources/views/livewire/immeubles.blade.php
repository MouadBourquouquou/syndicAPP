@extends('layouts.app')

@section('title', 'Liste des immeubles')

@push('styles')
<style>
    .card-immeuble {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .card-immeuble h5 {
        font-size: 1.1rem;
        margin-bottom: 10px;
        color: #1f2937;
    }
    .card-immeuble table {
        width: 100%;
    }
    .card-immeuble td {
        padding: 6px 8px;
        vertical-align: top;
    }
    .actions {
        margin-top: 15px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .btn {
        padding: 6px 10px;
        border-radius: 5px;
        font-size: 0.85rem;
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
    <h4 class="mb-4">Liste des immeubles</h4>

    @forelse ($immeubles as $immeuble)
        <div class="card-immeuble">
            <h5>{{ $immeuble->nom }}</h5>
            <table>
                <tr><td><strong>Résidence :</strong></td><td>{{ $immeuble->residence->nom ?? 'N/A' }}</td></tr>
                <tr><td><strong>Ville :</strong></td><td>{{ $immeuble->ville }}</td></tr>
                <tr><td><strong>Adresse :</strong></td><td>{{ $immeuble->adresse }}</td></tr>
                <tr><td><strong>Appartements :</strong></td><td>{{ $immeuble->appartements_count ?? 0 }}</td></tr>
                <tr><td><strong>Cotisation :</strong></td><td>{{ $immeuble->cotisation ?? 0 }} DH</td></tr>
                <tr><td><strong>Caisse :</strong></td><td>{{ $immeuble->caisse ?? 0 }} DH</td></tr>
            </table>

            <div class="actions">
                <button type="button" class="btn btn-view" data-bs-toggle="modal" data-bs-target="#modalView{{ $immeuble->id }}">👁 Voir</button>
                <button type="button" class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $immeuble->id }}">✏️ Modifier</button>
                <form action="{{ route('immeubles.destroy', $immeuble->id) }}" method="POST" onsubmit="return confirm('Supprimer cet immeuble ?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-delete">🗑 Supprimer</button>
                </form>
            </div>
        </div>

        <!-- Modal Voir -->
        <div class="modal fade" id="modalView{{ $immeuble->id }}" tabindex="-1" aria-labelledby="viewLabel{{ $immeuble->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Détails de l'immeuble</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tr><th>Nom</th><td>{{ $immeuble->nom }}</td></tr>
                            <tr><th>Résidence</th><td>{{ $immeuble->residence->nom ?? 'N/A' }}</td></tr>
                            <tr><th>Ville</th><td>{{ $immeuble->ville }}</td></tr>
                            <tr><th>Adresse</th><td>{{ $immeuble->adresse }}</td></tr>
                            <tr><th>Appartements</th><td>{{ $immeuble->appartements_count ?? 0 }}</td></tr>
                            <tr><th>Cotisation</th><td>{{ $immeuble->cotisation ?? 0 }} DH</td></tr>
                            <tr><th>Caisse</th><td>{{ $immeuble->caisse ?? 0 }} DH</td></tr>
                            <tr><th>Créé le</th><td>{{ $immeuble->created_at->format('d/m/Y H:i') }}</td></tr>
                            <tr><th>Mis à jour</th><td>{{ $immeuble->updated_at->format('d/m/Y H:i') }}</td></tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Modifier -->
        <div class="modal fade" id="modalEdit{{ $immeuble->id }}" tabindex="-1" aria-labelledby="editLabel{{ $immeuble->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <form method="POST" action="{{ route('immeubles.update', $immeuble->id) }}">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Modifier l'immeuble</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nom</label>
                                    <input type="text" name="nom" class="form-control" value="{{ $immeuble->nom }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Résidence</label>
                                    <select name="residence_id" class="form-select" required>
                                        @foreach ($residences as $residence)
                                            <option value="{{ $residence->id }}" {{ $immeuble->residence_id == $residence->id ? 'selected' : '' }}>
                                                {{ $residence->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Ville</label>
                                    <input type="text" name="ville" class="form-control" value="{{ $immeuble->ville }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Adresse</label>
                                    <input type="text" name="adresse" class="form-control" value="{{ $immeuble->adresse }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Cotisation (DH)</label>
                                    <input type="number" step="0.01" name="cotisation" class="form-control" value="{{ $immeuble->cotisation }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Caisse (DH)</label>
                                    <input type="number" step="0.01" name="caisse" class="form-control" value="{{ $immeuble->caisse }}">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">💾 Enregistrer</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">❌ Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p>Aucun immeuble trouvé.</p>
    @endforelse
</div>
@endsection
