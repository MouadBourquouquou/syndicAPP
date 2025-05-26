@extends('layouts.app')

@section('title', 'Liste des immeubles')

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
        <h4>Liste des immeubles</h4>
        <a href="{{ route('immeuble.create') }}" class="btn btn-success">+ Ajouter un immeuble</a>
    </div>

    <table class="table table-bordered table-hover shadow-sm bg-white">
        <thead class="text-center">
            <tr>
                <th>Nom</th>
                <th>Adresse</th>
                <th>Nombre d'appartements</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <tr>
                <td>Immeuble Alpha</td>
                <td>123 rue Principale</td>
                <td>10</td>
                <td>
                    <button class="btn btn-view">👁 Voir</button>
                    <button class="btn btn-edit">✏️ Modifier</button>
                    <button class="btn btn-delete">🗑 Supprimer</button>
                </td>
            </tr>
            <tr>
                <td>Immeuble Beta</td>
                <td>45 avenue des Champs</td>
                <td>8</td>
                <td>
                    <button class="btn btn-view">👁 Voir</button>
                    <button class="btn btn-edit">✏️ Modifier</button>
                    <button class="btn btn-delete">🗑 Supprimer</button>
                </td>
            </tr>
            <tr>
                <td>Immeuble Gamma</td>
                <td>789 boulevard Central</td>
                <td>12</td>
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
