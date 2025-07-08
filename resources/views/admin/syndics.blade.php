@extends('layouts.app')

@section('title', 'Gestion des Syndics')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Liste des Syndics</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Ville</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($syndics as $syndic)
                <tr>
                    <td>{{ $syndic->id }}</td>
                    <td>{{ $syndic->name }}</td>
                    <td>{{ $syndic->prenom }}</td>
                    <td>{{ $syndic->email }}</td>
                    <td>{{ $syndic->ville }}</td>
                    <td>{{ $syndic->statut }}</td>
                    <td>
                        <a href="{{ route('admin.syndics.show', $syndic->id) }}" class="btn btn-info btn-sm">Voir</a>
                        <form action="{{ route('admin.syndics.delete', $syndic->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce syndic ?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $syndics->links() }}
</div>
@endsection
