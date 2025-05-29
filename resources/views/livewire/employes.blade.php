@extends('layouts.app')

@section('title', 'Liste des employés')

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
        font-size: 0.85rem;
    }
</style>
@endpush

@section('content')
<div class="container mt-4">
    <h4>Liste des employés</h4>

    <table class="table table-bordered table-hover shadow-sm bg-white text-center table-sm">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Ville</th>
                <th>Adresse</th>
                <th>Poste</th>
                <th>Immeuble</th>
                <th>Résidence</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($employes as $employe)
                <tr>
                    <td>{{ $employe->nom }}</td>
                    <td>{{ $employe->prenom }}</td>
                    <td>{{ $employe->email }}</td>
                    <td>{{ $employe->telephone }}</td>
                    <td>{{ $employe->ville }}</td>
                    <td>{{ $employe->adresse }}</td>
                    <td>{{ $employe->poste }}</td>

                    <td>{{ $employe->immeuble_id }}</td> {{-- ou $employe->immeuble->nom si relation définie --}}
                    <td>{{ $employe->residence_id }}</td> {{-- ou $employe->residence->nom si relation --}}


                    
                    <td>
                        <a href="{{ route('employes.show', $employe) }}" class="btn btn-view">👁 Voir</a>
                        <a href="{{ route('employes.edit', $employe) }}" class="btn btn-edit">✏️ Modifier</a>
                        <form action="{{ route('employes.destroy', $employe) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Voulez-vous vraiment supprimer cet employé ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">🗑 Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="15">Aucun employé trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $employes->links() }}
    </div>
</div>
@endsection
