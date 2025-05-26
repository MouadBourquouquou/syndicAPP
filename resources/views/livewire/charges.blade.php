@extends('layouts.app')

@section('title', 'Liste des charges')

@push('styles')
<style>
    .btn {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 500;
        color: white;
        border: none;
        cursor: pointer;
    }

    .btn-view {
        background-color: #111827;
    }

    .btn-edit {
        background-color: #3b82f6;
    }

    .btn-delete {
        background-color: #ef4444;
    }

    .btn:hover {
        opacity: 0.85;
    }

    .table thead {
        background-color: #f9fafb;
    }

    .table th, .table td {
        vertical-align: middle !important;
    }

    .badge {
        font-size: 0.75rem;
        padding: 5px 8px;
        border-radius: 12px;
        color: white;
        background-color: #10b981;
    }
</style>
@endpush

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Liste des charges</h4>
        <a href="{{ route('charges') }}" class="btn btn-success">+ Ajouter une charge</a>
    </div>

    <table class="table table-bordered table-hover shadow-sm bg-white">
        <thead class="text-center">
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Description</th>
                <th>Montant (DH)</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <tr>
                <td>1</td>
                <td>Électricité</td>
                <td>Facture d'électricité du mois d’avril</td>
                <td>120.00</td>
                <td>01/05/2025</td>
                <td>
                    <button class="btn btn-view">👁 Voir</button>
                    <button class="btn btn-edit">✏️ Modifier</button>
                    <button class="btn btn-delete">🗑 Supprimer</button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Nettoyage</td>
                <td>Entretien des escaliers et couloirs</td>
                <td>80.00</td>
                <td>10/05/2025</td>
                <td>
                    <button class="btn btn-view">👁 Voir</button>
                    <button class="btn btn-edit">✏️ Modifier</button>
                    <button class="btn btn-delete">🗑 Supprimer</button>
                </td>
            </tr>
            <!-- Ajouter d'autres charges ici -->
        </tbody>
    </table>
</div>
@endsection
