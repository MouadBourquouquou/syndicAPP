@php
    $layout = auth()->user()->statut === 'assistant_syndic' ? 'assistant.layouts.app' : 'layouts.app';
@endphp

@extends($layout)

@section('title', 'Liste des appartements')

@push('styles')
    <style>
        /* Style repris du design residence pour employes */
        .card-employe {
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
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12), 0 4px 8px rgba(0, 0, 0, 0.08);
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
            margin-bottom: 18px;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 30px 16px;
            transition: all 0.3s ease;
            font-size: 0.875rem;
            height: 50px !important;

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
        <h4 class="mb-4">Liste des appartements</h4>

        @forelse ($appartements as $appartement)
            <div class="card-employe">
                <h5>{{ $appartement->immeuble->nom ?? 'Immeuble inconnu' }} - Appartement {{ $appartement->numero }}</h5>

                <table>
                    <tr>
                        <td>Propriétaire</td>
                        <td>{{ $appartement->Nom }} {{ $appartement->Prenom }}</td>
                    </tr>
                    <tr>
                        <td>CIN</td>
                        <td>{{ $appartement->CIN_A }}</td>
                    </tr>
                    <tr>
                        <td>Surface</td>
                        <td>{{ $appartement->surface }} m²</td>
                    </tr>
                    <tr>
                        <td>Montant cotisation</td>
                        <td>{{ number_format($appartement->montant_cotisation_mensuelle, 2, ',', ' ') }} MAD</td>
                    </tr>
                    <tr>
                        <td>Téléphone</td>
                        <td>{{ $appartement->telephone }}</td>
                    </tr>
                    <tr>
                        <td>Dernier mois payé</td>
                        <td>
                            @if($appartement->dernier_mois_paye)
                                {{ \Carbon\Carbon::parse($appartement->dernier_mois_paye)->locale('fr_FR')->translatedFormat('F Y') }}
                            @else
                                Non renseigné
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="actions">
                    <button class="btn btn-view" data-bs-toggle="modal"
                        data-bs-target="#modalAppartement{{ $appartement->id_A }}">
                        👁 Voir
                    </button>
                    @if(auth()->user()->statut !== 'assistant_syndic')
                        <button type="button" class="btn btn-edit" data-bs-toggle="modal"
                            data-bs-target="#modalEditAppartement{{ $appartement->id_A }}">
                            <i class="fas fa-edit"></i> Modifier
                        </button>
                        <form action="{{ route('appartement.destroy', $appartement) }}" method="POST" 
                            id="deleteForm{{ $appartement->id_A }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-delete" type="button" 
                                onclick="confirmDelete({{ $appartement->id_A }}, '{{ $appartement->numero }}', '{{ $appartement->Nom }} {{ $appartement->Prenom }}')">
                                🗑 Supprimer
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Modal Voir -->
            <div class="modal fade" id="modalAppartement{{ $appartement->id_A }}" tabindex="-1"
                aria-labelledby="modalLabelAppartement{{ $appartement->id_A }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Détails de l'appartement {{ $appartement->numero }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Immeuble :</th>
                                    <td>{{ $appartement->immeuble->nom ?? 'Immeuble inconnu' }}</td>
                                </tr>
                                <tr>
                                    <th>Numéro :</th>
                                    <td>{{ $appartement->numero }}</td>
                                </tr>
                                <tr>
                                    <th>Propriétaire :</th>
                                    <td>{{ $appartement->Nom }} {{ $appartement->Prenom }}</td>
                                </tr>
                                <tr>
                                    <th>CIN :</th>
                                    <td>{{ $appartement->CIN_A }}</td>
                                </tr>
                                <tr>
                                    <th>Email :</th>
                                    <td>{{ $appartement->email }}</td>
                                </tr>
                                <tr>
                                    <th>Surface :</th>
                                    <td>{{ $appartement->surface }} m²</td>
                                </tr>
                                <tr>
                                    <th>Montant cotisation :</th>
                                    <td>{{ number_format($appartement->montant_cotisation_mensuelle, 2, ',', ' ') }} MAD</td>
                                </tr>
                                <tr>
                                    <th>Téléphone :</th>
                                    <td>{{ $appartement->telephone }}</td>
                                </tr>
                                <tr>
                                    <th>Dernier mois payé :</th>
                                    <td>
                                        @if($appartement->dernier_mois_paye)
                                            {{ \Carbon\Carbon::parse($appartement->dernier_mois_paye)->locale('fr_FR')->translatedFormat('F Y') }}
                                        @else
                                            Non renseigné
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Créé le :</th>
                                    <td>{{ $appartement->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Modifié le :</th>
                                    <td>{{ $appartement->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#modalPaiement{{ $appartement->id_A }}">
                                💳 Ajouter un paiement
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Modifier -->
            <div class="modal fade" id="modalEditAppartement{{ $appartement->id_A }}" tabindex="-1"
                aria-labelledby="modalEditLabelAppartement{{ $appartement->id_A }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <form action="{{ route('appartement.update', $appartement) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">

                                <h5 class="modal-title">Modifier l'appartement {{ $appartement->numero }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Immeuble</label>
                                    <select name="immeuble_id" class="form-control" required>
                                        @foreach($immeubles as $immeuble)
                                            <option value="{{ $immeuble->id }}" {{ $immeuble->id == $appartement->immeuble_id ? 'selected' : '' }}>
                                                {{ $immeuble->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Numéro</label>
                                    <input type="text" name="numero" class="form-control" value="{{ $appartement->numero }}"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nom du propriétaire</label>
                                    <input type="text" name="Nom" class="form-control" value="{{ $appartement->Nom }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Prénom du propriétaire</label>
                                    <input type="text" name="Prenom" class="form-control" value="{{ $appartement->Prenom }}"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">CIN</label>
                                    <input type="text" name="CIN_A" class="form-control" value="{{ $appartement->CIN_A }}"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ $appartement->email }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Surface (m²)</label>
                                    <input type="number" step="0.01" name="surface" class="form-control"
                                        value="{{ $appartement->surface }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Montant cotisation mensuelle (MAD)</label>
                                    <input type="number" step="0.01" name="montant_cotisation_mensuelle" class="form-control"
                                        value="{{ $appartement->montant_cotisation_mensuelle }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Téléphone</label>
                                    <input type="text" name="telephone" class="form-control"
                                        value="{{ $appartement->telephone }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Dernier mois payé</label>
                                    <input type="date" name="dernier_mois_paye" class="form-control"
                                        value="{{ $appartement->dernier_mois_paye ? \Carbon\Carbon::parse($appartement->dernier_mois_paye)->format('Y-m-d') : '' }}">
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

            <!-- Modal Ajouter Paiement -->
            <div class="modal fade" id="modalPaiement{{ $appartement->id_A }}" tabindex="-1"
                aria-labelledby="modalPaiementLabel{{ $appartement->id_A }}" aria-hidden="true"
                data-id="{{ $appartement->id_A }}" data-montant="{{ $appartement->montant_cotisation_mensuelle }}"
                data-mois-paye="{{ $appartement->dernier_mois_paye ? \Carbon\Carbon::parse($appartement->dernier_mois_paye)->month : 0 }}"
                data-annee-paye="{{ $appartement->dernier_mois_paye ? \Carbon\Carbon::parse($appartement->dernier_mois_paye)->year : 0 }}">
                <div class="modal-dialog modal-dialog-centered">
                    @if(auth()->user()->statut === 'assistant_syndic')
                        <form method="POST" action="{{ route('assistant.paiements.store') }}">
                    @else
                            <form method="POST" action="{{ route('paiements.store') }}">
                        @endif
                            @csrf
                            <input type="hidden" name="id_A" value="{{ $appartement->id_A }}">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ajouter un paiement</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Fermer"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="anneeSelect{{ $appartement->id_A }}" class="form-label">Année</label>
                                        <select name="annee" id="anneeSelect{{ $appartement->id_A }}"
                                            class="form-select annee-select" required>
                                            @php
                                                $currentYear = now()->year;
                                            @endphp
                                            @for ($year = $currentYear; $year >= 2020; $year--)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Mois à payer</label>
                                        <div class="d-flex flex-wrap gap-2">
                                            @php
                                                $months = [
                                                    1 => 'Janvier',
                                                    2 => 'Février',
                                                    3 => 'Mars',
                                                    4 => 'Avril',
                                                    5 => 'Mai',
                                                    6 => 'Juin',
                                                    7 => 'Juillet',
                                                    8 => 'Août',
                                                    9 => 'Septembre',
                                                    10 => 'Octobre',
                                                    11 => 'Novembre',
                                                    12 => 'Décembre',
                                                ];
                                            @endphp
                                            @foreach ($months as $num => $name)
                                                <div class="form-check">
                                                    <input class="form-check-input mois-checkbox" type="checkbox" value="{{ $num }}"
                                                        id="mois{{ $num }}-{{ $appartement->id_A }}" name="mois[]"
                                                        data-mois="{{ $num }}">
                                                    <label class="form-check-label" for="mois{{ $num }}-{{ $appartement->id_A }}">
                                                        {{ $name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="totalMontant{{ $appartement->id_A }}" class="form-label">Montant total
                                            (MAD)</label>
                                        <input type="text" id="totalMontant{{ $appartement->id_A }}" name="montant_total"
                                            class="form-control" value="0" readonly>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Enregistrer le paiement</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        @empty
            <p>Aucun appartement trouvé.</p>
        @endforelse
    </div>

    @push('scripts')
        <!-- SweetAlert2 CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <script>
            // SweetAlert Delete Confirmation Function
            function confirmDelete(id, numeroAppartement, proprietaire) {
                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    html: `Vous êtes sur le point de supprimer :<br>
                           <strong>Appartement ${numeroAppartement}</strong><br>
                           <span style="color: #6b7280;">Propriétaire: ${proprietaire}</span>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Oui, supprimer !',
                    cancelButtonText: 'Annuler',
                    reverseButtons: true,
                    customClass: {
                        popup: 'swal-popup',
                        title: 'swal-title',
                        content: 'swal-content',
                        confirmButton: 'swal-confirm',
                        cancelButton: 'swal-cancel'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Suppression en cours...',
                            text: 'Veuillez patienter',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        
                        // Submit the form
                        document.getElementById(`deleteForm${id}`).submit();
                    }
                });
            }

            document.addEventListener('DOMContentLoaded', function () {
                // Pour chaque modal paiement
                const modals = document.querySelectorAll('[id^="modalPaiement"]');

                modals.forEach(modal => {
                    const id = modal.dataset.id;
                    const montantMensuel = parseFloat(modal.dataset.montant);
                    const moisPaye = parseInt(modal.dataset.moisPaye);
                    const anneePaye = parseInt(modal.dataset.anneePaye);

                    const checkboxes = modal.querySelectorAll('.mois-checkbox');
                    const anneeSelect = modal.querySelector('.annee-select');
                    const totalInput = modal.querySelector(`#totalMontant${id}`);

                    if (!anneeSelect || !totalInput || checkboxes.length === 0) {
                        return; // sécurité
                    }

                    function updateTotal() {
                        let total = 0;
                        checkboxes.forEach(cb => {
                            if (cb.checked && !cb.disabled) total += montantMensuel;
                        });
                        totalInput.value = total.toFixed(2);
                    }

                    function updateMoisDisponibles() {
                        const selectedYear = parseInt(anneeSelect.value);

                        checkboxes.forEach(cb => {
                            const mois = parseInt(cb.dataset.mois);

                            if (selectedYear < anneePaye) {
                                cb.disabled = true;
                                cb.checked = false;
                            } else if (selectedYear === anneePaye) {
                                cb.disabled = mois <= moisPaye;
                                if (cb.disabled) cb.checked = false;
                            } else {
                                cb.disabled = false;
                            }
                        });

                        updateTotal();
                    }

                    anneeSelect.addEventListener('change', updateMoisDisponibles);
                    checkboxes.forEach(cb => cb.addEventListener('change', updateTotal));

                    // Initialisation au chargement modal
                    updateMoisDisponibles();
                });

                // Custom SweetAlert2 styles
                const style = document.createElement('style');
                style.textContent = `
                    .swal-popup {
                        border-radius: 16px !important;
                        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                    }
                    .swal-title {
                        font-weight: 700 !important;
                        color: #1f2937 !important;
                    }
                    .swal-content {
                        color: #6b7280 !important;
                    }
                    .swal-confirm {
                        border-radius: 10px !important;
                        font-weight: 600 !important;
                        padding: 10px 20px !important;
                    }
                    .swal-cancel {
                        border-radius: 10px !important;
                        font-weight: 600 !important;
                        padding: 10px 20px !important;
                    }
                `;
                document.head.appendChild(style);
            });
        </script>
    @endpush

@endsection
