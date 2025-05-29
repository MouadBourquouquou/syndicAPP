@extends('layouts.app')

@section('title', 'Liste des appartements')

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
        text-decoration: none;
        display: inline-block;
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

    .badge {
        font-size: 0.75rem;
        padding: 5px 8px;
        border-radius: 12px;
        color: white;
        background-color: #10b981;
    }

    .table thead {
        background-color: #f9fafb;
    }

    .table th, .table td {
        vertical-align: middle !important;
    }

    .me-1 {
        margin-right: 0.25rem; /* petit espace entre les boutons */
    }
</style>
@endpush

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Liste des appartements</h4>
       
    </div>

    <table class="table table-bordered table-hover shadow-sm bg-white">
        <thead class="text-center">
            <tr>
                
                <th>Numéro</th>
                <th>Immeuble</th>
                <th>Nom & Prenom</th>
                <th>Dernier mois payé</th>
                <th>Téléphone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @forelse ($appartements as $appartement)
                <tr>
                    <td>
                        @if($appartement->immeuble)
                            {{ $appartement->immeuble->nom }}
                        @else
                            <em class="text-muted">Immeuble inconnu</em>
                        @endif
                    </td>
                    <td>{{ $appartement->numero }}</td>
                    <td>{{ $appartement->Nom}} </td>
                    <td>
                        @if($appartement->dernier_mois_paye)
                            <span class="badge">
                                {{ \Carbon\Carbon::parse($appartement->dernier_mois_paye)->format('Y-m') }}
                            </span>
                        @else
                            <em class="text-muted">Non renseigné</em>
                        @endif
                    </td>
                    <td>{{ $appartement->telephone ?? '-' }}</td>
                    <td>
                        <a href="{{ route('appartement.show', $appartement) }}" class="btn btn-view me-1">👁 Voir</a>
                        <a href="{{ route('appartement.edit', $appartement) }}" class="btn btn-edit me-1">✏️ Modifier</a>
                        <form action="{{ route('appartement.destroy', $appartement) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Voulez-vous vraiment supprimer cet appartement ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">🗑 Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6"><em>Aucun appartement trouvé.</em></td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $appartements->links() }}
    </div>
</div>
@endsection
