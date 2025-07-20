@php
    $layout = auth()->user()->statut === 'assistant_syndic' ? 'assistant.layouts.app' : 'layouts.app';
@endphp

@extends($layout)

@section('title', 'Liste des résidences')

@push('styles')
    <style>
        /* Your existing CSS for .card-residence, buttons, modals, etc., goes here. */
        /* I'm omitting it for brevity but assume it's present and unchanged. */

        .card-residence {
            border: none;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08), 0 2px 4px rgba(0, 0, 0, 0.05);
            font-size: 0.875rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .card-residence::before {
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

        .card-residence:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12), 0 4px 8px rgba(0, 0, 0, 0.08);
        }

        .card-residence h5 {
            font-size: 1.25rem;
            margin-bottom: 16px;
            color: #1f2937;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card-residence table {
            width: 100%;
        }

        .card-residence td {
            padding: 8px 12px;
            vertical-align: top;
            border-bottom: 1px solid #f1f5f9;
        }

        .card-residence td:first-child {
            font-weight: 600;
            color: #475569;
            width: 40%;
        }

        .card-residence td:last-child {
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
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
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
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .btn:active {
            transform: translateY(0);
        }

        /* Modal modernization */
        .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
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

        .form-control , .form-select {
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

        .btn-success:hover,
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-success:active,
        .btn-secondary:active {
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
            .card-residence {
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
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15) !important;
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
        <h4 class="mb-4">Liste des résidences</h4>

        @forelse ($residences as $residence)
            <div class="card-residence">
                <h5>{{ $residence->nom }}</h5>
                <table>
                    <tr>
                        <td><strong>Ville :</strong></td>
                        <td>{{ $residence->ville }}</td>
                    </tr>
                    <tr>
                        <td><strong>Adresse :</strong></td>
                        <td>{{ $residence->adresse }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nombre d'immeubles :</strong></td>
                        <td>{{ $residence->nombre_immeubles }}</td>
                    </tr>
                </table>

                <div class="actions">
                    <button type="button" class="btn btn-view" data-bs-toggle="modal"
                        data-bs-target="#modalResidence{{ $residence->id }}">
                        👁 Voir
                    </button>
                    @if(auth()->user()->statut !== 'assistant_syndic')
                    <button type="button" class="btn btn-edit" data-bs-toggle="modal"
                        data-bs-target="#modalEditResidence{{ $residence->id }}">
                        <i class="fas fa-edit"></i> Modifier
                    </button>

                    <form action="{{ route('residences.destroy', $residence->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        {{-- REMOVED onsubmit from here and added onclick to the button --}}
                        <button type="button" class="btn btn-delete" onclick="confirmDelete(this)">🗑 Supprimer</button>
                    </form>
                    @endif
                </div>
            </div>

            <div class="modal fade" id="modalResidence{{ $residence->id }}" tabindex="-1"
                aria-labelledby="modalLabelResidence{{ $residence->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabelResidence{{ $residence->id }}">Détails de la résidence</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Nom :</th>
                                    <td>{{ $residence->nom }}</td>
                                </tr>
                                <tr>
                                    <th>Ville :</th>
                                    <td>{{ $residence->ville }}</td>
                                </tr>
                                <tr>
                                    <th>Adresse :</th>
                                    <td>{{ $residence->adresse }}</td>
                                </tr>
                                <tr>
                                    <th>Nombre d'immeubles :</th>
                                    <td>{{ $residence->nombre_immeubles }}</td>
                                </tr>
                                <tr>
                                    <th>Créé le :</th>
                                    <td>{{ $residence->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Modifié le :</th>
                                    <td>{{ $residence->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalEditResidence{{ $residence->id }}" tabindex="-1"
                aria-labelledby="modalEditLabelResidence{{ $residence->id }}" aria-hidden="true">
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
                                        <input type="text" id="nomResidence{{ $residence->id }}" name="nom" class="form-control"
                                            value="{{ $residence->nom }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="ville{{ $residence->id }}" class="form-label">Ville</label></br>
                                        <select id="ville{{ $residence->id }}" name="ville" class="form-select" required>
                                            @foreach ($villes as $ville)
                                                <option value="{{ $ville }}" {{ $residence->ville == $ville ? 'selected' : '' }}>
                                                    {{ $ville }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="adresseResidence{{ $residence->id }}" class="form-label">Adresse</label>
                                        <input type="text" id="adresseResidence{{ $residence->id }}" name="adresse"
                                            class="form-control" value="{{ $residence->adresse }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nombreImmeubles{{ $residence->id }}" class="form-label">Nombre
                                            d'immeubles</label>
                                        <input type="number" id="nombreImmeubles{{ $residence->id }}" name="nombre_immeubles"
                                            class="form-control" value="{{ $residence->nombre_immeubles }}" min="0" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer mt-3">
                                <button type="submit" class="btn btn-success">Enregistrer</button>
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
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(button) {
            Swal.fire({
                title: 'Supprimer cette résidence ?', // Changed "appartement" to "résidence"
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
                url("/images/nyan-cat.gif") // Ensure this path is correct if you're using it
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

                    // Submit the form only if confirmed
                    button.closest('form').submit();
                }
            });
        }
    </script>

    <style>
        /* Custom SweetAlert2 styles */
        /* Your existing SweetAlert2 styles go here, they are already excellent! */
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
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15) !important;
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