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

    .form-control ,.form-select{
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 12px 16px;
        transition: all 0.3s ease;
        font-size: 0.875rem;
        height: 48px;
         color: #6b7280;
    }

    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    .form-control:invalid {
        border-color: #ef4444;
    }

    .form-control:invalid:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .text-danger {
        color: #ef4444 !important;
    }

    /* Style for select multiple */
    select[multiple] {
        min-height: 120px;
        padding: 8px;
        height: auto;
    }

    select[multiple] option {
        padding: 8px 12px;
        margin: 2px 0;
        border-radius: 6px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
    }

    select[multiple] option:selected {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border-color: #3b82f6;
    }

    /* Form text styling */
    .form-text {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 4px;
    }

    /* Textarea specific styling */
    textarea.form-control {
        resize: vertical;
        min-height: 80px;
        font-family: inherit;
        height: auto;
    }

    /* Required field indicator */
    .form-label .text-danger {
        font-size: 0.875rem;
        margin-left: 2px;
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

        .modal-dialog {
            margin: 10px;
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .form-control {
            font-size: 16px; /* Prevents zoom on iOS */
        }
        
        select[multiple] {
            min-height: 100px;
        }
    }

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
                    <td>
                        @if(isset($employe->residences) && $employe->residences->count() > 0)
                            {{ $employe->residences->pluck('nom')->join(', ') }}
                        @else
                            Aucune résidence
                        @endif
                    </td>
                </tr>


            </table>

            <div class="actions">
                <!-- Voir détails avec modal -->
                <button type="button" class="btn btn-view" data-bs-toggle="modal" data-bs-target="#modalEmploye{{ $employe->id_E }}" aria-label="Voir détails de {{ $employe->nom }} {{ $employe->prenom }}">
                    👁 Voir
                </button>

                <!-- Modifier avec modal -->
                <button type="button" class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditEmploye{{ $employe->id_E }}">
                    <i class="fas fa-edit"></i> Modifier
                </button>

                <!-- Supprimer -->
                <form action="{{ route('employes.destroy', $employe->id_E) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
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
        <div class="modal fade" id="modalEditEmploye{{ $employe->id_E }}" tabindex="-1" aria-labelledby="modalEditLabelEmploye{{ $employe->id_E }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditLabelEmploye{{ $employe->id_E }}">Modifier l'employé</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <form action="{{ route('employes.update', $employe->id_E) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nom{{ $employe->id_E }}" class="form-label">Nom <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nom{{ $employe->id_E }}" name="nom" value="{{ old('nom', $employe->nom) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="prenom{{ $employe->id_E }}" class="form-label">Prénom <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="prenom{{ $employe->id_E }}" name="prenom" value="{{ old('prenom', $employe->prenom) }}" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email{{ $employe->id_E }}" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email{{ $employe->id_E }}" name="email" value="{{ old('email', $employe->email) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="telephone{{ $employe->id_E }}" class="form-label">Téléphone</label>
                                    <input type="tel" class="form-control" id="telephone{{ $employe->id_E }}" name="telephone" value="{{ old('telephone', $employe->telephone) }}">
                                </div>
                            </div>
                            
                            <div class="row">
                                 <div class="col-md-6">
                                <label for="ville{{ $employe->id_E }}" class="form-label">Ville</label>
                                <select id="ville{{ $employe->id_E }}" name="ville" class="form-select" required>

                                @foreach ($villes as $ville)
                                    <option value="{{ $ville }}"
                                        {{ $employe->ville == $ville ? 'selected' : '' }}>
                                        {{ $ville }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                                <div class="col-md-6 mb-3">
                                    <label for="poste{{ $employe->id_E }}" class="form-label">Poste</label>
                                    <input type="text" class="form-control" id="poste{{ $employe->id_E }}" name="poste" value="{{ old('poste', $employe->poste) }}">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="adresse{{ $employe->id_E }}" class="form-label">Adresse</label>
                                <textarea class="form-control" id="adresse{{ $employe->id_E }}" name="adresse" rows="3">{{ old('adresse', $employe->adresse) }}</textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="residence_id{{ $employe->id_E }}" class="form-label">Résidence</label>
                                    <select class="form-control" id="residence_id{{ $employe->id_E }}" name="residence_id">
                                        <option value="">Sélectionner une résidence</option>
                                        @if(isset($residences))
                                            @foreach($residences as $residence)
                                                <option value="{{ $residence->id }}" 
                                                    {{ old('residence_id', $employe->residence_id) == $residence->id ? 'selected' : '' }}>
                                                    {{ $residence->nom }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="immeubles{{ $employe->id_E }}" class="form-label">Immeubles</label>
                                    <select class="form-control" id="immeubles{{ $employe->id_E }}" name="immeubles[]" multiple>
                                        @if(isset($immeubles))
                                            @foreach($immeubles as $immeuble)
                                                <option value="{{ $immeuble->id }}" 
                                                    {{ (old('immeubles') && in_array($immeuble->id, old('immeubles'))) || 
                                                       (!old('immeubles') && $employe->immeubles && $employe->immeubles->contains('id', $immeuble->id)) ? 'selected' : '' }}>
                                                    {{ $immeuble->nom }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <small class="form-text text-muted">Maintenez Ctrl pour sélectionner plusieurs immeubles</small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-success">
                                Enregistrer les modifications
                            </button>
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
        title: 'Supprimer cet employé ?',
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
@endpush