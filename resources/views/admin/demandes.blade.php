@extends('layouts.app')

@section('title', 'Demandes en attente')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Liste des demandes en attente</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($demandes->isEmpty())
        <p>Aucune demande en attente.</p>
    @else
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Statut</th>
                    <th>Ville</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($demandes as $demande)
                    <tr>
                        <td>{{ $demande->id }}</td>
                        <td>{{ $demande->name }}</td>
                        <td>{{ $demande->prenom }}</td>
                        <td>{{ $demande->email }}</td>
                        <td>{{ $demande->statut }}</td>
                        <td>{{ $demande->ville }}</td>
                        <td>
                            <!-- Accepter (devient activer) -->
                            <form action="{{ route('admin.demandes.activer', $demande->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Accepter</button>
                            </form>

                            <!-- Refuser -->
                            <form action="{{ route('admin.demandes.refuser', $demande->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Refuser</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
