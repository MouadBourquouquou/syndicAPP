@php
    $layout = auth()->user()->statut === 'assistant_syndic' ? 'assistant.layouts.app' : 'layouts.app';
@endphp

@extends($layout)

@section('title', 'Liste des charges')

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

    .form-control, .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 12px 16px;
        transition: all 0.3s ease;
        font-size: 0.875rem;
        min-height: 48px;
    }

    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-select {
        background-position: right 12px center;
        background-repeat: no-repeat;
        background-size: 16px 12px;
        padding-right: 200px;
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }


    .btn-filter {
    padding: 10px 18px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.875rem;
    text-decoration: none;
    transition: all 0.3s ease;
    color: #374151;
    background: #c5daeeff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
}

.btn-filter:hover {
    background: #e0f2fe;
    color: #0c4a6e;
}

.btn-filter.active {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white !important;
    border-color: #2563eb;
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

    .btn-success:active, .btn-secondary:active {
        transform: translateY(0);
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

    /* Validation errors */
    .invalid-feedback {
        display: block;
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 5px;
    }

    .is-invalid {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
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
@if(auth()->user()->statut === 'assistant_syndic')
<div class="container mt-4">
    <h4 class="mb-4">Liste des charges</h4>

   <div class="filters d-flex flex-wrap mb-4" style="column-gap:20px;">
    <a href="{{ route('assistant.charges.index') }}"
       class="btn-filter {{ request('etat') == null ? 'active' : '' }} ">
        Toutes
    </a>
    <a href="{{ route('assistant.charges.index', ['etat' => 'payée']) }}"
       class="btn-filter {{ request('etat') == 'payée' ? 'active' : '' }}">
        Payées
    </a>
    <a href="{{ route('assistant.charges.index', ['etat' => 'non payée']) }}"
       class="btn-filter {{ request('etat') == 'non payée' ? 'active' : '' }}">
        Non Payées
    </a>
</div>
@else
<div class="container mt-4">
    <h4 class="mb-4">Liste des charges</h4>

   <div class="filters d-flex flex-wrap mb-4" style="column-gap:20px;">
    <a href="{{ route('charges.index') }}"
       class="btn-filter {{ request('etat') == null ? 'active' : '' }} ">
        Toutes
    </a>
    <a href="{{ route('charges.index', ['etat' => 'payée']) }}"
       class="btn-filter {{ request('etat') == 'payée' ? 'active' : '' }}">
        Payées
    </a>
    <a href="{{ route('charges.index', ['etat' => 'non payée']) }}"
       class="btn-filter {{ request('etat') == 'non payée' ? 'active' : '' }}">
        Non Payées
    </a>
</div>
@endif


    @forelse ($charges as $charge)
        <div class="card-employe">
            <h5>Charge : {{ $charge->id }} - {{ $charge->type }}</h5>

            <table>
                <tr>
                    <td>Résidence</td>
                    <td>
                        @if(isset($charge->residence->nom))
                            {{ $charge->residence->nom }}
                        @else
                            {{ $charge->residence_id }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Immeuble</td>
                    <td>
                        @if(isset($charge->immeuble->nom))
                            {{ $charge->immeuble->nom }}
                        @else
                            {{ $charge->immeuble_id }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Montant</td>
                    <td>{{ number_format($charge->montant, 2) }} DH</td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td>{{ \Carbon\Carbon::parse($charge->date)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td>{{ $charge->description }}</td>
                </tr>
            </table>

            <div class="actions">
                <button class="btn btn-view" data-bs-toggle="modal" data-bs-target="#modalCharge{{ $charge->id }}">
                    👁 Voir
                </button>

                <button type="button" class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditCharge{{ $charge->id }}">
                    <i class="fas fa-edit"></i> Modifier
                </button>
                @if(auth()->user()->statut === 'assistant_syndic')
                <form action="{{ route('assistant.charges.destroy', $charge->id) }}" method="POST" class="delete-form">
                @else
                <form action="{{ route('charges.destroy', $charge->id) }}" method="POST" class="delete-form">
                @endif
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-delete" type="button" onclick="confirmDelete(this)">🗑 Supprimer</button>
                </form>
            </div>
        </div>

        <!-- Modal Voir -->
        <div class="modal fade" id="modalCharge{{ $charge->id }}" tabindex="-1" aria-labelledby="modalLabelCharge{{ $charge->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Détails de la charge #{{ $charge->id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-borderless">
                            <tr><th>Type :</th><td>{{ $charge->type }}</td></tr>
                            <tr>
                                <th>Résidence :</th>
                                <td>
                                    @if(isset($charge->residence->nom))
                                        {{ $charge->residence->nom }}
                                    @else
                                        {{ $charge->residence_id }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Immeuble :</th>
                                <td>
                                    @if(isset($charge->immeuble->nom))
                                        {{ $charge->immeuble->nom }}
                                    @else
                                        {{ $charge->immeuble_id }}
                                    @endif
                                </td>
                            </tr>
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
                    @if(auth()->user()->statut === 'assistant_syndic')
                    <form action="{{ route('assistant.charges.update', $charge->id) }}" method="POST" class="delete-form">
                    @else
                    <form action="{{ route('charges.update', $charge->id) }}" method="POST" class="delete-form">
                    @endif
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Modifier la charge #{{ $charge->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Type <span class="text-danger">*</span></label></br>
                                        
                                        <input type="text" name="type" 
                                               class="form-control @error('type') is-invalid @enderror" 
                                               value="{{ $charge->type }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Montant (DH) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" min="0" name="montant" 
                                               class="form-control @error('montant') is-invalid @enderror" 
                                               value="{{ $charge->montant }}" required>
                                        @error('montant')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Résidence <span class="text-danger">*</span></label>
                                        @if(isset($residences) && $residences->count() > 0)
                                            <select name="id_residence" class="form-select @error('id_residence') is-invalid @enderror" required>
                                                <option value="">Sélectionner une résidence</option>
                                                @foreach($residences as $residence)
                                                    <option value="{{ $residence->id }}" 
                                                            {{ $charge->id_residence == $residence->id ? 'selected' : '' }}>
                                                        {{ $residence->nom }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input type="text" name="id_residence" 
                                                   class="form-control @error('id_residence') is-invalid @enderror" 
                                                   value="{{ $charge->residence->nom ?? $charge->id_residence }}"
 required>
                                        @endif
                                        @error('id_residence')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Immeuble <span class="text-danger">*</span></label>
                                        @if(isset($immeubles) && $immeubles->count() > 0)
                                            <select name="immeuble_id" class="form-select @error('immeuble_id') is-invalid @enderror" required>
                                                <option value="">Sélectionner un immeuble</option>
                                                @foreach($immeubles as $immeuble)
                                                    <option value="{{ $immeuble->id }}" 
                                                            {{ $charge->immeuble_id == $immeuble->id ? 'selected' : '' }}>
                                                        {{ $immeuble->nom }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input type="text" name="immeuble_id" 
                                                   class="form-control @error('immeuble_id') is-invalid @enderror" 
                                                   value="{{ $charge->immeuble_id }}" required>
                                        @endif
                                        @error('immeuble_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" name="date" 
                                       class="form-control @error('date') is-invalid @enderror" 
                                       value="{{ \Carbon\Carbon::parse($charge->date)->format('Y-m-d') }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" 
                                          class="form-control @error('description') is-invalid @enderror" 
                                          rows="3" placeholder="Description de la charge...">{{ $charge->description }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">
                                Enregistrer les modifications
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="fas fa-receipt fa-3x text-muted"></i>
            </div>
            <p class="text-muted">Aucune charge trouvée.</p>
        </div>
    @endforelse
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmDelete(button) {
    Swal.fire({
        title: 'Supprimer cette charge ?',
        text: "Cette action est irréversible !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Annuler',
        background: '#ffffff',
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

// Validation côté client
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form[novalidate]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                
                // Afficher un message d'erreur
                Swal.fire({
                    title: 'Erreur de validation',
                    text: 'Veuillez corriger les erreurs dans le formulaire.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
            
            form.classList.add('was-validated');
        }, false);
    });
});
</script>
@endpush