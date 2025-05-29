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
    </div>

    <table class="table table-bordered table-hover shadow-sm bg-white">
        <thead class="text-center">
            <tr>
             
                <th>Nom Residence</th>
                <th>Nom d'Immeuble</th>
                <th>Type</th>
                <th>Description</th>
                <th>Montant (DH)</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="text-center">
                @forelse ($charges as $charge)
                <tr>
                <td>{{ $charge->immeuble_id }}</td> {{-- ou $charge->immeuble->nom si relation définie --}}
                    <td>{{ $charge->residence_id }}</td> {{-- ou $charge->residence->nom si relation --}}

                    <td>{{ $charge->type }}</td>
                    <td>{{ $charge->description }}</td>
                    <td>{{ number_format($charge->montant, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($charge->date)->format('d/m/Y') }}</td>

                    <td>
                        <button class="btn btn-view">👁 Voir</button>
                        <button class="btn btn-edit">✏️ Modifier</button>
                        <button class="btn btn-delete">🗑 Supprimer</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6"><em>Aucune charge trouvée.</em></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
