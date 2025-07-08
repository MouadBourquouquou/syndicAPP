@extends('layouts.app')

@section('title', 'Liste des employés')

@push('styles')
<style>
    /* Style repris du design residence pour employes */
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

    .actions {
        margin-top: 20px;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .btn {
        padding: 10px 16px;
        border-radius: 10px;
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
        gap: 6px;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-view { 
        background: linear-gradient(135deg, #111827 0%, #374151 100%);
        box-shadow: 0 4px 12px rgba(17, 24, 39, 0.3);
    }

    .btn-edit { 
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .btn-delete { 
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn:hover { 
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .btn:active {
        transform: translateY(0);
    }

    /* Modal modernization */
    .modal-content {
        border: none;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        backdrop-filter: blur(10px);
    }

    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 16px 16px 0 0;
        padding: 20px 24px;
        border-bottom: none;
    }

    .modal-title {
        font-weight: 700;
        font-size: 1.25rem;
    }

    .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
    }

    .btn-close:hover {
        opacity: 1;
    }

    .modal-body {
        padding: 24px;
    }

    .modal-footer {
        padding: 20px 24px;
        border-top: 1px solid #e5e7eb;
        background: #f9fafb;
        border-radius: 0 0 16px 16px;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 12px 16px;
        transition: all 0.3s ease;
        font-size: 0.875rem;
        height: 48px;
    }

    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-secondary {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
    }

    .btn-success:hover, .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .table-borderless th {
        font-weight: 600;
        color: #374151;
        padding: 12px 16px;
        width: 35%;
    }

    .table-borderless td {
        color: #6b7280;
        padding: 12px 16px;
    }

    /* Container and header */
    .container {
        max-width: 1200px;
    }

    h4 {
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

    /* Animations */
    @keyframes shimmer {
        0% {
            background-position: -200% 0;
        }
        100% {
            background-position: 200% 0;
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-employe {
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
        
        h4 {
            font-size: 1.5rem;
        }
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
                <button type="button" class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditResidence{{ $employe->id }}">
    <i class="fas fa-edit"></i> Modifier

                <!-- Supprimer -->
               <form action="{{ route('employes.destroy', $employe->id_E) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    {{-- Changed type to "button" and added onclick for SweetAlert2 --}}
                    <button class="btn btn-delete" type="button" onclick="confirmDelete(this)">🗑 Supprimer</button>
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
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(button) {
    Swal.fire({
        title: 'Supprimer cet appartement ?',
        text: "Cette action est irréversible !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler',
        background: '#ffffff',
        backdrop: `
            rgba(0,0,0,0.4)
            url("/images/nyan-cat.gif")
            left top
            no-repeat
        `,
        customClass: {
            popup: 'animated fadeInDown',
            title: 'swal-title',
            content: 'swal-content',
            confirmButton: 'swal-confirm-btn',
            cancelButton: 'swal-cancel-btn'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            Swal.fire({
                title: 'Suppression en cours...',
                text: 'Veuillez patienter',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading()
                }
            });
            
            // Submit the form
            button.closest('form').submit();
        }
    });
}
</script>

<style>
/* Custom SweetAlert2 styles */
.swal-title {
    font-weight: 700 !important;
    color: #1f2937 !important;
    font-size: 1.5rem !important;
}

.swal-content {
    color: #6b7280 !important;
    font-size: 1rem !important;
}

.swal-confirm-btn {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
    border: none !important;
    border-radius: 10px !important;
    padding: 12px 24px !important;
    font-weight: 600 !important;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3) !important;
    transition: all 0.3s ease !important;
}

.swal-confirm-btn:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4) !important;
}

.swal-cancel-btn {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%) !important;
    border: none !important;
    border-radius: 10px !important;
    padding: 12px 24px !important;
    font-weight: 600 !important;
    box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3) !important;
    transition: all 0.3s ease !important;
}

.swal-cancel-btn:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 20px rgba(107, 114, 128, 0.4) !important;
}

.swal2-popup {
    border-radius: 16px !important;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15) !important;
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translate3d(0, -100%, 0);
    }
    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}
</style>
@endpush