@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Historique des Paiements</h1>

    <div class="mb-3">
        <a href="{{ route('paiements.index', ['filtre' => 'complet']) }}" class="btn btn-success">Payé 12 mois</a>
        <a href="{{ route('paiements.index', ['filtre' => 'incomplet']) }}" class="btn btn-warning">Incomplet</a>
        <a href="{{ route('paiements.index', ['filtre' => 'retard']) }}" class="btn btn-danger">Retard</a>
        <a href="{{ route('paiements.index') }}" class="btn btn-secondary">Tous</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Appartement</th>
                <th>Immeuble</th>
                <th>Résidence</th>
                <th>Mois payés</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($paiements as $paiement)
                <tr>
                    <td>{{ $paiement->appartement->numero ?? '-' }}</td>
                    <td>{{ $paiement->appartement->immeuble->nom ?? '-' }}</td>
                    <td>{{ $paiement->appartement->immeuble->residence->nom ?? '-' }}</td>
                    <td>
                        @foreach (json_decode($paiement->mois_payes, true) ?? [] as $mois)
                            <span class="badge bg-primary">{{ \Carbon\Carbon::parse($mois)->format('F Y') }}</span>
                        @endforeach
                    </td>
                    <td>{{ $paiement->montant }} MAD</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Aucun paiement trouvé pour ce filtre.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
