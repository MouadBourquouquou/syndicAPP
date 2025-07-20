@php
    $layout = auth()->user()->statut === 'assistant_syndic' ? 'assistant.layouts.app' : 'layouts.app';
@endphp

@extends($layout)

@section('title', 'Liste des immeubles')

@push('styles')
<style>
    .card-immeuble {
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

    .card-immeuble::before {
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

    .card-immeuble:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12), 0 4px 8px rgba(0,0,0,0.08);
    }

    .card-immeuble h5 {
        font-size: 1.25rem;
        margin-bottom: 16px;
        color: #1f2937;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .card-immeuble table {
        width: 100%;
    }

    .card-immeuble td {
        padding: 8px 12px;
        vertical-align: top;
    }

    .card-immeuble td:first-child {
        font-weight: 600;
        color: #475569;
        width: 40%;
    }

    .card-immeuble td:last-child {
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
    tr{
        border:none;
    }

    .modal-body {
        padding: 24px;
    }

    .modal-footer {
        padding: 20px 24px;
        background: #f9fafb;
        border-radius: 0 0 16px 16px;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 12px 16px;
        transition: all 0.3s ease;
        font-size: 0.875rem;
    }
    .form-select{
        width:50%
        padding:2px;
    }
    .form-control:focus, .form-select:focus {
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
        .card-immeuble {
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

    /* No data message styling */
    .no-data-message {
        text-align: center;
        padding: 60px 20px;
        color: #6b7280;
        font-size: 1.1rem;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
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
                <button type="button" class="btn btn-view" data-bs-toggle="modal" data-bs-target="#modalView{{ $immeuble->id }}">
                    👁 Voir
                </button>
                @if(auth()->user()->statut !== 'assistant_syndic')
                <button type="button" class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $immeuble->id }}">
                    <i class="fas fa-edit"></i> Modifier
                </button>
                <form action="{{ route('immeubles.destroy', $immeuble->id) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    {{-- Changed type to "button" and added onclick for SweetAlert2 --}}
                    <button class="btn btn-delete" type="button" onclick="confirmDelete(this)">🗑 Supprimer</button>
                </form>
                @endif
            </div>
        </div>

        <!-- Modal Voir -->
        <div class="modal fade" id="modalView{{ $immeuble->id }}" tabindex="-1" aria-labelledby="viewLabel{{ $immeuble->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Détails de l'immeuble</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table ">
                            <tr><th>Nom:</th><td>{{ $immeuble->nom }}</td></tr>
                            <tr><th>Résidence:</th><td>{{ $immeuble->residence->nom ?? 'N/A' }}</td></tr>
                            <tr><th>Ville:</th><td>{{ $immeuble->ville }}</td></tr>
                            <tr><th>Adresse:</th><td>{{ $immeuble->adresse }}</td></tr>
                            <tr><th>Appartements:</th><td>{{ $immeuble->appartements_count ?? 0 }}</td></tr>
                            <tr><th>Cotisation:</th><td>{{ $immeuble->cotisation ?? 0 }} DH</td></tr>
                            <tr><th>Caisse:</th><td>{{ $immeuble->caisse ?? 0 }} DH</td></tr>
                            <tr><th>Créé le:</th><td>{{ $immeuble->created_at->format('d/m/Y H:i') }}</td></tr>
                            <tr><th>Mis à jour:</th><td>{{ $immeuble->updated_at->format('d/m/Y H:i') }}</td></tr>
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
                            <h5 class="modal-title">Modifier l'immeuble - <strong>{{ $immeuble->nom }}</strong></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nom{{ $immeuble->id }}" class="form-label">Nom</label>
                                    <input type="text" id="nom{{ $immeuble->id }}" name="nom" class="form-control" value="{{ $immeuble->nom }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="residence{{ $immeuble->id }}" class="form-label">Résidence</label></br>
                                    <select id="residence{{ $immeuble->id }}" name="residence_id" class="form-select" required>
                                        @foreach ($residences as $residence)
                                            <option value="{{ $residence->id }}" {{ $immeuble->residence_id == $residence->id ? 'selected' : '' }}>
                                                {{ $residence->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                            <label for="ville{{ $immeuble->id }}" class="form-label">Ville</label></br>
                            <select id="ville{{ $immeuble->id }}" name="ville" class="form-select" required>
                                @foreach ($villes as $ville)
                                    <option value="{{ $ville }}"
                                        {{ $immeuble->ville == $ville ? 'selected' : '' }}>
                                        {{ $ville }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                                <div class="col-md-6">
                                    <label for="adresse{{ $immeuble->id }}" class="form-label">Adresse</label>
                                    <input type="text" id="adresse{{ $immeuble->id }}" name="adresse" class="form-control" value="{{ $immeuble->adresse }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="cotisation{{ $immeuble->id }}" class="form-label">Cotisation (DH)</label>
                                    <input type="number" step="0.01" id="cotisation{{ $immeuble->id }}" name="cotisation" class="form-control" value="{{ $immeuble->cotisation }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="caisse{{ $immeuble->id }}" class="form-label">Caisse (DH)</label>
                                    <input type="number" step="0.01" id="caisse{{ $immeuble->id }}" name="caisse" class="form-control" value="{{ $immeuble->caisse }}">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="no-data-message">
            <p>Aucun immeuble trouvé.</p>
        </div>
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