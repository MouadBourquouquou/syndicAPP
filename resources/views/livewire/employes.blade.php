@extends('layouts.app')

@section('title', 'Liste des employés')

@push('styles')
<style>
    .card-employe {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        font-size: 0.875rem;
    }
    .card-employe h5 {
        font-size: 1rem;
        margin-bottom: 10px;
        color: #1f2937;
    }
    .card-employe table {
        width: 100%;
        border-collapse: collapse;
    }
    .card-employe td {
        padding: 10px 12px;
        vertical-align: top;
    }
    /* Zebra striping */
    .card-employe table tr:nth-child(even) {
        background-color: #f9fafb;
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
        transition: opacity 0.3s ease;
    }
    .btn-view { background-color: #111827; }
    .btn-edit { background-color: #3b82f6; }
    .btn-delete { background-color: #ef4444; }
    .btn:hover { opacity: 0.85; }

    /* Form text small for multiselect */
    small.form-text.text-muted {
        display: block;
        margin-top: 4px;
        color: #6b7280;
    }

    /* === DESIGN MODALES PERSONNALISÉ === */
    .modal-content {
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #ffffff;
    }

    .modal-header {
        border-bottom: none;
        padding: 1.5rem 2rem;
        background-color: #f8fafc;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .modal-header .modal-title {
        font-weight: 700;
        font-size: 1.25rem;
        color: #111827;
    }

    .btn-close {
        filter: brightness(0.5);
        transition: filter 0.3s ease;
    }

    .btn-close:hover {
        filter: brightness(0.8);
    }

    .modal-body {
        padding: 1.5rem 2rem;
        font-size: 0.95rem;
        color: #374151;
    }

    .modal-footer {
        border-top: none;
        padding: 1rem 2rem;
        background-color: #f8fafc;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    .modal-footer .btn {
        min-width: 100px;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 0.5rem 1.2rem;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

    .modal-footer .btn-primary {
        background-color: #2563eb;
        border: none;
    }

    .modal-footer .btn-primary:hover {
        background-color: #1e40af;
    }

    .modal-footer .btn-secondary {
        background-color: #e5e7eb;
        color: #374151;
        border: none;
    }

    .modal-footer .btn-secondary:hover {
        background-color: #d1d5db;
    }

    /* Table dans modal */
    .modal-body table th {
        width: 150px;
        font-weight: 600;
        color: #4b5563;
        padding-bottom: 0.6rem;
    }

    .modal-body table td {
        color: #374151;
        vertical-align: middle;
        padding-bottom: 0.6rem;
    }
</style>
@endpush

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Liste des employés</h4>

    @forelse ($employes as $employe)
        <div class="card-employe">
            <h5>{{ $employe->nom }} {{ $employe->prenom }}</h5>
            <table>
                <tr><td><strong>Email :</strong></td><td>{{ $employe->email }}</td></tr>
                <tr><td><strong>Téléphone :</strong></td><td>{{ $employe->telephone }}</td></tr>
                <tr><td><strong>Ville :</strong></td><td>{{ $employe->ville }}</td></tr>
                <tr><td><strong>Adresse :</strong></td><td>{{ $employe->adresse }}</td></tr>
                <tr><td><strong>Poste :</strong></td><td>{{ $employe->poste }}</td></tr>
                <tr>
                    <td><strong>Immeubles :</strong></td>
                    <td>
                        @if($employe->immeubles && $employe->immeubles->count() > 0)
                            {{ $employe->immeubles->pluck('nom')->join(', ') }}
                        @else
                            Aucun immeuble
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>Résidence :</strong></td>
                    <td>{{ $employe->residence ? $employe->residence->nom : 'Aucune résidence' }}</td>
                </tr>
            </table>

            <div class="actions">
                <!-- Voir détails avec modal -->
                <button type="button" class="btn btn-view" data-bs-toggle="modal" data-bs-target="#modalEmploye{{ $employe->id_E }}" aria-label="Voir détails de {{ $employe->nom }} {{ $employe->prenom }}">
                    👁 Voir
                </button>

                <!-- Modifier avec modal -->
                <button type="button" class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditEmploye{{ $employe->id_E }}" aria-label="Modifier {{ $employe->nom }} {{ $employe->prenom }}">
                    ✏️ Modifier
                </button>

                <!-- Supprimer -->
                <form action="{{ route('employes.destroy', $employe->id_E) }}" method="POST" class="d-inline" onsubmit="return confirm('Voulez-vous vraiment supprimer cet employé ?');" aria-label="Supprimer {{ $employe->nom }} {{ $employe->prenom }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete">🗑 Supprimer</button>
                </form>
            </div>
        </div>

        <!-- Modal Voir -->
        <div class="modal fade" id="modalEmploye{{ $employe->id_E }}" tabindex="-1" aria-labelledby="modalLabelEmploye{{ $employe->id_E }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabelEmploye{{ $employe->id_E }}">Détails de l'employé</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-borderless">
                            <tr><th>Nom :</th><td>{{ $employe->nom }}</td></tr>
                            <tr><th>Prénom :</th><td>{{ $employe->prenom }}</td></tr>
                            <tr><th>Email :</th><td>{{ $employe->email }}</td></tr>
                            <tr><th>Téléphone :</th><td>{{ $employe->telephone }}</td></tr>
                            <tr><th>Ville :</th><td>{{ $employe->ville }}</td></tr>
                            <tr><th>Adresse :</th><td>{{ $employe->adresse }}</td></tr>
                            <tr><th>Poste :</th><td>{{ $employe->poste }}</td></tr>
                            <tr><th>Immeubles :</th>
                                <td>
                                    @if($employe->immeubles && $employe->immeubles->count() > 0)
                                        {{ $employe->immeubles->pluck('nom')->join(', ') }}
                                    @else
                                        Aucun immeuble
                                    @endif
                                </td>
                            </tr>
                            <tr><th>Résidence :</th><td>{{ $employe->residence ? $employe->residence->nom : 'Aucune résidence' }}</td></tr>
                            <tr><th>Créé le :</th><td>{{ $employe->created_at->format('d/m/Y H:i') }}</td></tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Modifier -->
        <div class="modal fade" id="modalEditEmploye{{ $employe->id_E }}" tabindex="-1" aria-labelledby="modalLabelEditEmploye{{ $employe->id_E }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabelEditEmploye{{ $employe->id_E }}">Modifier l'employé</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <form method="POST" action="{{ route('employes.update', $employe->id_E) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nom{{ $employe->id_E }}" class="form-label">Nom</label>
                                <input type="text" name="nom" id="nom{{ $employe->id_E }}" value="{{ old('nom', $employe->nom) }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="prenom{{ $employe->id_E }}" class="form-label">Prénom</label>
                                <input type="text" name="prenom" id="prenom{{ $employe->id_E }}" value="{{ old('prenom', $employe->prenom) }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email{{ $employe->id_E }}" class="form-label">Email</label>
                                <input type="email" name="email" id="email{{ $employe->id_E }}" value="{{ old('email', $employe->email) }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="telephone{{ $employe->id_E }}" class="form-label">Téléphone</label>
                                <input type="text" name="telephone" id="telephone{{ $employe->id_E }}" value="{{ old('telephone', $employe->telephone) }}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="ville{{ $employe->id_E }}" class="form-label">Ville</label>
                                <input type="text" name="ville" id="ville{{ $employe->id_E }}" value="{{ old('ville', $employe->ville) }}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="adresse{{ $employe->id_E }}" class="form-label">Adresse</label>
                                <input type="text" name="adresse" id="adresse{{ $employe->id_E }}" value="{{ old('adresse', $employe->adresse) }}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="poste{{ $employe->id_E }}" class="form-label">Poste</label>
                                <input type="text" name="poste" id="poste{{ $employe->id_E }}" value="{{ old('poste', $employe->poste) }}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="immeubles{{ $employe->id_E }}" class="form-label">Immeubles</label>
                                <select name="immeubles[]" id="immeubles{{ $employe->id_E }}" class="form-select" multiple size="4">
                                    @foreach ($immeubles as $immeuble)
                                        <option value="{{ $immeuble->id }}" 
                                            {{ $employe->immeubles && $employe->immeubles->contains($immeuble->id) ? 'selected' : '' }}>
                                            {{ $immeuble->nom }}
                                        </option>
                                        
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs immeubles.</small>
                            </div>
                            <div class="mb-3">
                                <label for="residence{{ $employe->id_E }}" class="form-label">Résidence</label>
                                <select name="residence_id" id="residence{{ $employe->id_E }}" class="form-select">
                                    <option value="">-- Choisir une résidence --</option>
                                    @foreach ($residences as $residence)
                                        <option value="{{ $residence->id }}" 
                                            {{ $employe->residence && $employe->residence->id == $residence->id ? 'selected' : '' }}>
                                            {{ $residence->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @empty
        <p>Aucun employé trouvé.</p>
    @endforelse
</div>
@endsection
