@extends('layouts.app')

@section('title', 'Liste des résidences')

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
        white-space: nowrap;
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
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .table td:last-child, .table th:last-child {
        max-width: none;
        white-space: nowrap;
        width: 180px;
    }

    .table-responsive {
        overflow-x: auto;
        width: 100%;
        -webkit-overflow-scrolling: touch;
    }

    .table td:last-child {
        display: flex;
        justify-content: center;
        gap: 6px;
    }
</style>
@endpush

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Liste des résidences</h4>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover shadow-sm bg-white">
            <thead class="text-center">
                <tr>
                   
                    <th>Nom de residence</th>
                    <th>ville</th>
                    <th>Adresse</th>
                    <th>Nombre d’immeubles</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse ($residences as $residence)
                <tr>
                    
                    <td>{{ $residence->nom }}</td>
                    <td>{{ $residence->ville }}</td>
                    <td>{{ $residence->adresse }}</td>
                    <td>{{ $residence-> nombre_immeubles}}</td>
                    
                    <td>
                        <button class="btn btn-view">👁 Voir</button>
                        <button class="btn btn-edit">✏️ Modifier</button>
                        <button class="btn btn-delete">🗑 Supprimer</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">Aucune résidence trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
