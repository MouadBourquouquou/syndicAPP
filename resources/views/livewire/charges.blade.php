@extends('layouts.app')

@section('title', 'Liste des charges')

@push('styles')
<style>
    .card-charge {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        font-size: 0.875rem;
    }
    .card-charge h5 {
        font-size: 1rem;
        margin-bottom: 10px;
        color: #1f2937;
    }
    .card-charge .card-body {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
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
    <h4 class="mb-4">Liste des charges</h4>

    @forelse ($charges as $charge)
        <div class="card-charge">
            <h5>Charge #{{ $charge->id }} - {{ $charge->type }}</h5>

            <div class="card-body">
                <div class="card-field">
                    <strong>Résidence</strong>
                    <span>{{ $charge->residence_id }}</span> {{-- ou $charge->residence->nom si relation --}}
                </div>

                <div class="card-field">
                    <strong>Immeuble</strong>
                    <span>{{ $charge->immeuble_id }}</span> {{-- ou $charge->immeuble->nom si relation --}}
                </div>

                <div class="card-field">
                    <strong>Montant</strong>
                    <span>{{ number_format($charge->montant, 2) }} DH</span>
                </div>

                <div class="card-field">
                    <strong>Date</strong>
                    <span>{{ \Carbon\Carbon::parse($charge->date)->format('d/m/Y') }}</span>
                </div>

                <div class="card-field">
                    <strong>Description</strong>
                    <span>{{ $charge->description }}</span>
                </div>
            </div>

            <div class="actions">
                <!-- Bouton Voir (Modal) -->
                <button type="button" class="btn btn-view" data-bs-toggle="modal" data-bs-target="#modalCharge{{ $charge->id }}">
                    👁 Voir
                </button>

                <!-- Bouton Modifier (Modal) -->
                <button type="button" class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditCharge{{ $charge->id }}">
                    ✏️ Modifier
                </button>

                <!-- Bouton Supprimer (Formulaire) -->
                <form action="{{ route('charges.destroy', $charge->id) }}" method="POST" onsubmit="return confirm('Supprimer cette charge ?');" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete">🗑 Supprimer</button>
                </form>
            </div>
        </div>

        <!-- Modal Voir -->
        <div class="modal fade" id="modalCharge{{ $charge->id }}" tabindex="-1" aria-labelledby="modalLabelCharge{{ $charge->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabelCharge{{ $charge->id }}">Détails de la charge #{{ $charge->id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-borderless">
                            <tr><th>Type :</th><td>{{ $charge->type }}</td></tr>
                            <tr><th>Résidence :</th><td>{{ $charge->residence_id }}</td></tr>
                            <tr><th>Immeuble :</th><td>{{ $charge->immeuble_id }}</td></tr>
                            <tr><th>Montant :</th><td>{{ number_format($charge->montant, 2) }} DH</td></tr>
                            <tr><th>Date :</th><td>{{ \Carbon\Carbon::parse($charge->date)->format('d/m/Y') }}</td></tr>
                            <tr><th>Description :</th><td>{{ $charge->description }}</td></tr>
                            <tr><th>Créé le :</th><td>{{ $charge->created_at->format('d/m/Y H:i') }}</td></tr>
                            <tr><th>Modifié le :</th><td>{{ $charge->updated_at->format('d/m/Y H:i') }}</td></tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Modifier -->
        <div class="modal fade" id="modalEditCharge{{ $charge->id }}" tabindex="-1" aria-labelledby="modalEditLabelCharge{{ $charge->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <form action="{{ route('charges.update', $charge->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditLabelCharge{{ $charge->id }}">Modifier la charge #{{ $charge->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="typeCharge{{ $charge->id }}" class="form-label">Type</label>
                                <input type="text" id="typeCharge{{ $charge->id }}" name="type" class="form-control" value="{{ $charge->type }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="residenceCharge{{ $charge->id }}" class="form-label">Résidence</label>
                                <input type="text" id="residenceCharge{{ $charge->id }}" name="residence_id" class="form-control" value="{{ $charge->residence_id }}" required>
                                {{-- Remplace par un select si tu as une liste de résidences --}}
                            </div>
                            <div class="mb-3">
                                <label for="immeubleCharge{{ $charge->id }}" class="form-label">Immeuble</label>
                                <input type="text" id="immeubleCharge{{ $charge->id }}" name="immeuble_id" class="form-control" value="{{ $charge->immeuble_id }}" required>
                                {{-- Remplace par un select si tu as une liste d'immeubles --}}
                            </div>
                            <div class="mb-3">
                                <label for="montantCharge{{ $charge->id }}" class="form-label">Montant</label>
                                <input type="number" step="0.01" id="montantCharge{{ $charge->id }}" name="montant" class="form-control" value="{{ $charge->montant }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="dateCharge{{ $charge->id }}" class="form-label">Date</label>
                                <input type="date" id="dateCharge{{ $charge->id }}" name="date" class="form-control" value="{{ \Carbon\Carbon::parse($charge->date)->format('Y-m-d') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="descriptionCharge{{ $charge->id }}" class="form-label">Description</label>
                                <textarea id="descriptionCharge{{ $charge->id }}" name="description" class="form-control" rows="3">{{ $charge->description }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p>Aucune charge trouvée.</p>
    @endforelse
</div>
@endsection
