@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Bienvenue dans le Dashboard Admin</h1>

    <div class="alert alert-success">
        Vous êtes connecté en tant qu'<strong>administrateur</strong>.
    </div>

    <ul class="list-group mt-4">
        <li class="list-group-item">
            <a href="{{ route('admin.demandes') }}">📥 Voir les demandes d’inscription</a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('admin.syndics') }}">👥 Gérer les syndics</a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('admin.admins.index') }}">🛠️ Gérer les administrateurs</a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                🚪 Se déconnecter
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</div>
@endsection
