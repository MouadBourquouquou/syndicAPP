@extends('layouts.app')

@section('title', 'Liste des employés')

@push('styles')
<style>
    .card-employe {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        font-size: 0.875rem;
    }
    .card-employe h5 {
        font-size: 1rem;
        margin-bottom: 10px;
        color: #1f2937;
    }
    .card-employe table {
        width: 100%;
    }
    .card-employe td {
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
    <h4 class="mb-4">Liste des employés</h4>

    @forelse ($employes as $employe)
        <div class="card-employe">
            <h5>{{ $employe->nom }} {{ $employe->prenom }}</h5>
            <table>
                <tr>
                    <td><strong>Email :</strong></td>
                    <td>{{ $employe->email }}</td>
                </tr>
                <tr>
                    <td><strong>Téléphone :</strong></td>
                    <td>{{ $employe->telephone }}</td>
                </tr>
                <tr>
                    <td><strong>Ville :</strong></td>
                    <td>{{ $employe->ville }}</td>
                </tr>
                <tr>
                    <td><strong>Adresse :</strong></td>
                    <td>{{ $employe->adresse }}</td>
                </tr>
                <tr>
                    <td><strong>Poste :</strong></td>
                    <td>{{ $employe->poste }}</td>
                </tr>
                <tr>
                    <td><strong>Immeubles :</strong></td>
                    <td>
                        @if($employe->immeubles && $employe->immeubles->count() > 0)
                            {{ $employe->immeubles->pluck('nom')->join(', ') }}
                        @else
                            Aucun immeuble
                        @endif
                    </td>
                </tr>
                <tr>
                    
                    <td><strong>Résidence :</strong></td>
    <td>
        {{ $employe->residence ? $employe->residence->nom : 'Aucune résidence' }}
    </td>
                </tr>
            </table>

            <div class="actions">
                <a href="{{ route('employes.show', $employe) }}" class="btn btn-view">👁 Voir</a>
                <a href="{{ route('employes.edit', $employe) }}" class="btn btn-edit">✏️ Modifier</a>
                <form action="{{ route('employes.destroy', $employe) }}" method="POST" class="d-inline" onsubmit="return confirm('Voulez-vous vraiment supprimer cet employé ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete">🗑 Supprimer</button>
                </form>
            </div>
        </div>
    @empty
        <p>Aucun employé trouvé.</p>
    @endforelse

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $employes->links() }}
    </div>
</div>
@endsection
