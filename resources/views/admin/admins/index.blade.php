@extends('layouts.app')

@section('title', 'Gestion des administrateurs')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Liste des administrateurs</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary mb-3">➕ Ajouter un administrateur</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $admin)
                <tr>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->prenom }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>
                        <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Supprimer cet admin ?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">🗑 Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach

            @if($admins->isEmpty())
                <tr>
                    <td colspan="4" class="text-center">Aucun administrateur trouvé.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
