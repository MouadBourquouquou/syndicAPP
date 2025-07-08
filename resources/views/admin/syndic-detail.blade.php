@extends('layouts.app')

@section('title', 'Détail du Syndic')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Détails du Syndic</h2>

    <!-- Info syndic -->
    <div class="card mb-4 shadow">
        <div class="card-body">
            <p><strong>ID :</strong> {{ $syndic->id }}</p>
            <p><strong>Nom :</strong> {{ $syndic->name }}</p>
            <p><strong>Prénom :</strong> {{ $syndic->prenom }}</p>
            <p><strong>Email :</strong> {{ $syndic->email }}</p>
            <p><strong>Statut :</strong> {{ $syndic->statut }}</p>
            <p><strong>Nom Société :</strong> {{ $syndic->nom_societé ?? '---' }}</p>
            <p><strong>Adresse :</strong> {{ $syndic->adresse }}</p>
            <p><strong>Téléphone :</strong> {{ $syndic->tel }}</p>
            <p><strong>Fax :</strong> {{ $syndic->Fax ?? '---' }}</p>
            <p><strong>Ville :</strong> {{ $syndic->ville }}</p>
        </div>
    </div>

    <!-- Résidences -->
    <h4>Résidences gérées</h4>
    @if ($residences->isEmpty())
        <p>Aucune résidence trouvée.</p>
    @else
        <ul class="list-group mb-4">
            @foreach ($residences as $residence)
                <li class="list-group-item">
                    <strong>{{ $residence->nom }}</strong> — {{ $residence->ville }}
                </li>
            @endforeach
        </ul>
    @endif

    <!-- Immeubles -->
    <h4>Immeubles associés</h4>
    @if ($immeubles->isEmpty())
        <p>Aucun immeuble trouvé.</p>
    @else
        <ul class="list-group mb-4">
            @foreach ($immeubles as $immeuble)
                <li class="list-group-item">
                    <strong>{{ $immeuble->nom }}</strong> — {{ $immeuble->ville }}
                    @if($immeuble->residence)
                        <small class="text-muted">(Résidence : {{ $immeuble->residence->nom }})</small>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('admin.demandes') }}" class="btn btn-secondary">← Retour</a>
</div>
@endsection
