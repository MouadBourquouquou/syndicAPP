@extends('layouts.app')

@section('title', 'Liste des charges')

@push('styles')
<style>
    .card-charge {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        font-size: 0.875rem;
    }
    .card-charge h5 {
        font-size: 1rem;
        margin-bottom: 10px;
        color: #1f2937;
    }
    .card-charge .card-body {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 10px;
    }
    .card-field {
        margin-bottom: 8px;
    }
    .card-field strong {
        display: block;
        color: #6b7280;
        font-size: 0.8rem;
    }
    .card-field span {
        display: block;
        font-size: 0.9rem;
    }
    .badge {
        font-size: 0.75rem;
        padding: 5px 8px;
        border-radius: 12px;
        color: white;
        background-color: #10b981;
    }
    .actions {
        margin-top: 15px;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .btn {
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 500;
        color: white;
        border: none;
        cursor: pointer;
    }
    .btn-view { background-color: #111827; }
    .btn-edit { background-color: #3b82f6; }
    .btn-delete { background-color: #ef4444; }
    .btn:hover { opacity: 0.85; }
</style>
@endpush

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Liste des charges</h4>

    @forelse ($charges as $charge)
        <div class="card-charge">
            <h5>Charge #{{ $charge->id }} - {{ $charge->type }}</h5>
            
            <div class="card-body">
                <div class="card-field">
                    <strong>Résidence</strong>
                    <span>{{ $charge->residence_id }}</span> {{-- ou $charge->residence->nom si relation --}}
                </div>
                
                <div class="card-field">
                    <strong>Immeuble</strong>
                    <span>{{ $charge->immeuble_id }}</span> {{-- ou $charge->immeuble->nom si relation définie --}}
                </div>
                
                <div class="card-field">
                    <strong>Montant</strong>
                    <span>{{ number_format($charge->montant, 2) }} DH</span>
                </div>
                
                <div class="card-field">
                    <strong>Date</strong>
                    <span>{{ \Carbon\Carbon::parse($charge->date)->format('d/m/Y') }}</span>
                </div>
                
                <div class="card-field">
                    <strong>Description</strong>
                    <span>{{ $charge->description }}</span>
                </div>
            </div>

            <div class="actions">
                <button class="btn btn-view">👁 Voir</button>
                <button class="btn btn-edit">✏️ Modifier</button>
                <button class="btn btn-delete">🗑 Supprimer</button>
            </div>
        </div>
    @empty
        <p>Aucune charge trouvée.</p>
    @endforelse
</div>
@endsection