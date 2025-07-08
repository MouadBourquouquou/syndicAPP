@extends('layouts.app')

@section('title', 'Ajouter un administrateur')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Ajouter un nouvel administrateur</h1>

    <form action="{{ route('admin.admins.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Nom :</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" name="prenom" class="form-control" value="{{ old('prenom') }}" required>
        </div>

        <div class="form-group">
            <label for="email">Adresse email :</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmer le mot de passe :</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button class="btn btn-success mt-3">✅ Ajouter</button>
    </form>
</div>
@endsection
