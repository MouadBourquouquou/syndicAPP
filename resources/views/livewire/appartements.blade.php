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
            padding: 10px 14px;
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
            gap : 10px;
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
    <style>
    /* Modal Payment Styles */
    .payment-modal {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
        background: #ffffff;
        max-width: 800px;
        margin: auto;
        transform: scale(0.95);
    }

    .payment-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 10px;
        position: relative;
    }

    .payment-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        pointer-events: none;
    }

    .header-icon {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
        backdrop-filter: blur(10px);
    }

    .header-icon i {
        font-size: 20px;
        color: white;
    }

    .modal-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: white;
    }

    .payment-body {
        padding: 10px;
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    }

    .form-section {
        margin-bottom: 25px;
        position: relative;
    }

    .form-section:last-child {
        margin-bottom: 0;
    }

    .form-label {
        font-size: 0.95rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .form-label i {
        color: #667eea;
    }

    .custom-select, .custom-input {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 0px 14px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: white;
        height: 30px;
    }

    .custom-select:focus, .custom-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .input-group-text {
        background: #667eea;
        color: white;
        border: 2px solid #667eea;
        border-left: none;
        border-radius: 0 12px 12px 0;
        font-weight: 600;
    }

    /* Months Grid */
    .months-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 5px;
    }

    .month-item {
        position: relative;
    }

    .month-item input[type="checkbox"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .month-label {
        display: block;
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 5px 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .month-label::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
        transition: left 0.5s ease;
    }

    .month-label:hover::before {
        left: 100%;
    }

    .month-name {
        display: block;
        font-weight: 600;
        color: #374151;
        font-size: 0.85rem;
        margin-bottom: 4px;
    }

    .month-number {
        display: block;
        font-size: 0.75rem;
        color: #6b7280;
        font-weight: 500;
    }

    .month-item input:checked + .month-label {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    .month-item input:checked + .month-label .month-name,
    .month-item input:checked + .month-label .month-number {
        color: white;
    }

    .month-item input:disabled + .month-label {
        background: #f3f4f6;
        border-color: #d1d5db;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .month-item input:disabled + .month-label .month-name,
    .month-item input:disabled + .month-label .month-number {
        color: #9ca3af;
    }

    .month-label:hover {
        border-color: #667eea;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
    }

    .month-item input:disabled + .month-label:hover {
        transform: none;
        box-shadow: none;
        border-color: #d1d5db;
    }

    /* Footer */
    .payment-footer {
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
        padding: 5px;
        gap: 5px;
    }

    .btn-cancel, .btn-save {
        padding: 5px 10px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .btn-cancel {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: white;
    }

    .btn-save {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .btn-cancel:hover, .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .btn-cancel::before, .btn-save::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-cancel:hover::before, .btn-save:hover::before {
        left: 100%;
    }

    /* SweetAlert2 Custom Styles */
    .swal-popup {
        border-radius: 20px !important;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .swal-title {
        font-weight: 700 !important;
        color: #1f2937 !important;
    }

    .swal-content {
        color: #6b7280 !important;
    }

    .swal-confirm, .swal-cancel {
        border-radius: 12px !important;
        font-weight: 600 !important;
        padding: 10px 20px !important;
        font-size: 0.9rem !important;
    }

    /* Responsive Scaling */
    @media (max-width: 1024px) {
        .payment-modal {
            transform: scale(0.9);
        }
        .modal-title {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 768px) {
        .months-grid {
            grid-template-columns: repeat(3, 1fr);
        }
        .payment-modal {
            transform: scale(0.85);
        }
        .payment-body, .payment-header {
            padding: 15px;
        }
        .custom-input, .custom-select {
            height: 40px;
            font-size: 0.85rem;
        }
    }

    @media (max-width: 480px) {
        .months-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .payment-modal {
            transform: scale(0.8);
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
                    <button type="button" class="btn btn-view" data-bs-toggle="modal"
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


            <!-- Payment Modal -->
<div class="modal fade" id="modalPaiement{{ $appartement->id_A }}" tabindex="-1"
    aria-labelledby="modalPaiementLabel{{ $appartement->id_A }}" aria-hidden="true"
    data-id="{{ $appartement->id_A }}" 
    data-montant="{{ $appartement->montant_cotisation_mensuelle }}"
    data-mois-paye="{{ $appartement->dernier_mois_paye ? \Carbon\Carbon::parse($appartement->dernier_mois_paye)->month : 0 }}"
    data-annee-paye="{{ $appartement->dernier_mois_paye ? \Carbon\Carbon::parse($appartement->dernier_mois_paye)->year : 0 }}">
    <div class="modal-dialog modal-dialog-centered">
        @if(auth()->user()->statut === 'assistant_syndic')
            <form id="paymentForm{{ $appartement->id_A }}" method="POST" action="{{ route('assistant.paiements.store') }}">
        @else
            <form id="paymentForm{{ $appartement->id_A }}" method="POST" action="{{ route('paiements.store') }}">
        @endif
            @csrf
            <input type="hidden" name="id_A" value="{{ $appartement->id_A }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un paiement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body payment-body">
                    <!-- Section Année -->
                    <div class="form-section">
                        <label for="anneeSelect{{ $appartement->id_A }}" class="form-label">
                            <i class="fas fa-calendar-alt me-2"></i>Année de paiement
                        </label>
                        @php
                            $currentYear = now()->year;
                        @endphp
                        <select name="annee" id="anneeSelect{{ $appartement->id_A }}" class="form-select custom-select annee-select" required>
                            <option value="{{ $currentYear - 1 }}">{{ $currentYear - 1 }}</option>
                            <option value="{{ $currentYear }}" selected>{{ $currentYear }}</option>
                            <option value="{{ $currentYear + 1 }}">{{ $currentYear + 1 }}</option>
                        </select>
                    </div>

                    <!-- Section Mois -->
                    <div class="form-section">
                        <label class="form-label">
                            <i class="fas fa-calendar-check me-2"></i>Mois à payer
                        </label>
                        <div class="months-grid">
                            @php
                                $months = [
                                    1 => ['name' => 'Janvier', 'number' => '01'],
                                    2 => ['name' => 'Février', 'number' => '02'],
                                    3 => ['name' => 'Mars', 'number' => '03'],
                                    4 => ['name' => 'Avril', 'number' => '04'],
                                    5 => ['name' => 'Mai', 'number' => '05'],
                                    6 => ['name' => 'Juin', 'number' => '06'],
                                    7 => ['name' => 'Juillet', 'number' => '07'],
                                    8 => ['name' => 'Août', 'number' => '08'],
                                    9 => ['name' => 'Septembre', 'number' => '09'],
                                    10 => ['name' => 'Octobre', 'number' => '10'],
                                    11 => ['name' => 'Novembre', 'number' => '11'],
                                    12 => ['name' => 'Décembre', 'number' => '12']
                                ];
                            @endphp
                            
                            @foreach($months as $num => $month)
                            <div class="month-item">
                                <input class="form-check-input mois-checkbox" type="checkbox" value="{{ $num }}" 
                                       id="mois{{ $num }}-{{ $appartement->id_A }}" name="mois[]" data-mois="{{ $num }}">
                                <label class="month-label" for="mois{{ $num }}-{{ $appartement->id_A }}">
                                    <span class="month-name">{{ $month['name'] }}</span>
                                    <span class="month-number">{{ $month['number'] }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Section Montant Total -->
                    <div class="form-section">
                        <label for="totalMontant{{ $appartement->id_A }}" class="form-label">
                            <i class="fas fa-money-bill-wave me-2"></i>Montant total
                        </label>
                        <div class="input-group">
                            <input type="text" id="totalMontant{{ $appartement->id_A }}" name="montant_total" 
                                   class="form-control custom-input" value="0" readonly>
                            <span class="input-group-text">MAD</span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer payment-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Annuler
                    </button>
                    <button type="button" class="btn btn-save" onclick="confirmPayment(event, {{ $appartement->id_A }})">
                        <i class="fas fa-save me-2"></i>Enregistrer le paiement
                    </button>
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


document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[id^="modalPaiement"]').forEach(modal => {
        const apptId = modal.dataset.id;
        const monthlyAmount = parseFloat(modal.dataset.montant);
        const lastPaidMonth = parseInt(modal.dataset.moisPaye) || 0;
        const lastPaidYear = parseInt(modal.dataset.anneePaye) || 0;
        const currentYear = new Date().getFullYear();
        
        const yearSelect = modal.querySelector('.annee-select');
        const monthCheckboxes = modal.querySelectorAll('.mois-checkbox');
        const totalInput = modal.querySelector(`#totalMontant${apptId}`);
        const yearOptions = yearSelect.querySelectorAll('option');
        
        // Fonction pour vérifier si une année est complètement payée
        function isYearFullyPaid(year) {
            // Si l'année est antérieure à la dernière année payée, elle est complète
            if (year < lastPaidYear) return true;
            
            // Si c'est la dernière année payée, vérifier si tous les mois sont payés
            if (year === lastPaidYear) {
                return lastPaidMonth === 12;
            }
            
            // Pour l'année courante ou future, vérifier les mois cochés
            let allMonthsPaid = true;
            monthCheckboxes.forEach(cb => {
                if (!cb.disabled && !cb.checked) {
                    allMonthsPaid = false;
                }
            });
            return allMonthsPaid;
        }
        
        // Mettre à jour l'état des options d'année
        function updateYearOptions() {
            const currentYearPaid = isYearFullyPaid(currentYear);
            
            yearOptions.forEach(option => {
                const year = parseInt(option.value);
                
                // Désactiver les années futures si l'année courante n'est pas complète
                if (year > currentYear) {
                    option.disabled = !currentYearPaid;
                    
                    // Ajouter un indicateur visuel
                    if (option.disabled) {
                        option.title = "Complétez tous les mois de "+currentYear+" d'abord";
                    } else {
                        option.removeAttribute('title');
                    }
                }
            });
        }
        
        // Fonction pour mettre à jour les mois disponibles
        function updateAvailableMonths() {
            const selectedYear = parseInt(yearSelect.value);
            
            // Désactiver les mois déjà payés
            monthCheckboxes.forEach(cb => {
                const month = parseInt(cb.value);
                cb.disabled = (selectedYear < lastPaidYear) || 
                            (selectedYear === lastPaidYear && month <= lastPaidMonth);
                
                if (cb.disabled) cb.checked = false;
            });
            
            updateTotal();
            updateYearOptions();
        }
        
        // Fonction de vérification de séquence
        function checkMonthSequence(clickedCheckbox) {
            if (clickedCheckbox.disabled) return false;
            
            const clickedMonth = parseInt(clickedCheckbox.value);
            const selectedYear = parseInt(yearSelect.value);
            
            let refMonth = lastPaidMonth + 1;
            let refYear = lastPaidYear;
            
            if (refMonth > 12) {
                refMonth = 1;
                refYear++;
            }
            
            while (refYear < selectedYear || (refYear === selectedYear && refMonth < clickedMonth)) {
                const cb = modal.querySelector(`.mois-checkbox[value="${refMonth}"]`);
                if (cb && !cb.disabled && !cb.checked) {
                    Swal.fire({
                        title: 'Séquence incorrecte',
                        html: `Vous devez d'abord payer <strong>${getMonthName(refMonth)} ${refYear}</strong>`,
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    clickedCheckbox.checked = false;
                    return false;
                }
                
                refMonth++;
                if (refMonth > 12) {
                    refMonth = 1;
                    refYear++;
                }
            }
            return true;
        }
        
        // Helper pour obtenir le nom du mois
        function getMonthName(monthNumber) {
            const months = ['', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 
                          'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
            return months[monthNumber];
        }
        
        // Fonction de mise à jour du total
        function updateTotal() {
            let total = 0;
            monthCheckboxes.forEach(cb => {
                if (cb.checked && !cb.disabled) {
                    total += monthlyAmount;
                }
            });
            totalInput.value = total.toFixed(2);
        }
        
        // Événements
        yearSelect.addEventListener('change', updateAvailableMonths);
        
        monthCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                if (checkMonthSequence(this)) {
                    updateTotal();
                    updateYearOptions(); // Mettre à jour les options d'année après changement
                }
            });
        });
        
        // Initialisation
        updateAvailableMonths();
    });
});

// Fonction de confirmation de paiement (inchangée)
function confirmPayment(event) {
    const form = event.target.closest('form');
    const checkedMonths = form.querySelectorAll('.mois-checkbox:checked');
    const totalAmount = form.querySelector('[name="montant_total"]').value;
    const selectedYear = form.querySelector('.annee-select').value;
    
    if (checkedMonths.length === 0) {
        Swal.fire({
            title: 'Aucun mois sélectionné',
            text: 'Veuillez sélectionner au moins un mois à payer.',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
        return;
    }
    
    const monthNames = {
        1: 'Janvier', 2: 'Février', 3: 'Mars', 4: 'Avril',
        5: 'Mai', 6: 'Juin', 7: 'Juillet', 8: 'Août',
        9: 'Septembre', 10: 'Octobre', 11: 'Novembre', 12: 'Décembre'
    };
    
    const selectedMonthsText = Array.from(checkedMonths)
        .map(cb => monthNames[parseInt(cb.value)])
        .join(', ');
    
    Swal.fire({
        title: 'Confirmer le paiement',
        html: `
            <div style="text-align: left; margin: 20px 0;">
                <p><strong>Année :</strong> ${selectedYear}</p>
                <p><strong>Mois :</strong> ${selectedMonthsText}</p>
                <p><strong>Montant total :</strong> <span style="color: #10b981; font-weight: 700;">${totalAmount} MAD</span></p>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Confirmer',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Enregistrement en cours...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                    setTimeout(() => {
                        form.submit();
                    }, 500);
                }
            });
        }
    });
}
</script>

    @endpush

@endsection