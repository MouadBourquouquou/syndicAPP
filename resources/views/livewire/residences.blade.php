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
</style>
@endpush

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Liste des résidences</h4>
        <a href="{{ route('residence.create') }}" class="btn btn-success">+ Ajouter une résidence</a>
    </div>

    <table class="table table-bordered table-hover shadow-sm bg-white">
        <thead class="text-center">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Adresse</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <tr>
                <td>1</td>
                <td>Résidence Soleil</td>
                <td>123 Rue Principale</td>
                <td>
                    <button class="btn btn-view">👁 Voir</button>
                    <button class="btn btn-edit">✏️ Modifier</button>
                    <button class="btn btn-delete">🗑 Supprimer</button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Résidence Palmier</td>
                <td>45 Avenue des Fleurs</td>
                <td>
                    <button class="btn btn-view">👁 Voir</button>
                    <button class="btn btn-edit">✏️ Modifier</button>
                    <button class="btn btn-delete">🗑 Supprimer</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
