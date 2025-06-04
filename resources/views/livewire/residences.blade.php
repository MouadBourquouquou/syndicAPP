@extends('layouts.app')

@section('title', 'Liste des résidences')

@push('styles')
<style>
    .card-residence {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        font-size: 0.875rem;
    }
    .card-residence h5 {
        font-size: 1rem;
        margin-bottom: 10px;
        color: #1f2937;
    }
    .card-residence table {
        width: 100%;
    }
    .card-residence td {
        padding: 6px 8px;
        vertical-align: top;
    }
    .actions {
        margin-top: 10px;
    }
    .btn {
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 500;
        color: white;
        border: none;
        cursor: pointer;
        margin-right: 5px;
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
                    <td><strong>Nombre d’immeubles :</strong></td>
                    <td>{{ $residence->nombre_immeubles }}</td>
                </tr>
            </table>

            <div class="actions">
                <button class="btn btn-view">👁 Voir</button>
                <button class="btn btn-edit">✏️ Modifier</button>
                <button class="btn btn-delete">🗑 Supprimer</button>
            </div>
        </div>
    @empty
        <p>Aucune résidence trouvée.</p>
    @endforelse
</div>
@endsection
