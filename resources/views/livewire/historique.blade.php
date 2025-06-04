@extends('layouts.app')

@section('title', 'Historique des paiements')

@push('styles')
<style>
    .card-paiement {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        font-size: 0.875rem;
    }
    .card-paiement h5 {
        font-size: 1rem;
        margin-bottom: 10px;
        color: #1f2937;
    }
    .card-paiement .card-body {
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
    .filters {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
        align-items: flex-end;
    }
    .filter-group {
        flex: 1;
        min-width: 200px;
    }
    .btn-primary {
        background-color: #3b82f6;
        padding: 8px 15px;
        border-radius: 6px;
        color: white;
        border: none;
        cursor: pointer;
    }
    .btn-primary:hover {
        opacity: 0.85;
    }
</style>
@endpush

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Historique des paiements</h1>

    <div class="filters">
        <div class="filter-group">
            <label for="filtre_appartements" class="form-label">Filtrer par :</label>
            <select id="filtre_appartements" class="form-control">
                <option value="tous">Tous les appartements</option>
                <option value="retard">En retard de paiement</option>
                <option value="avance">Paiement en avance</option>
            </select>
        </div>

        <div class="filter-group">
            <label for="tri_situation" class="form-label">Trier par :</label>
            <select id="tri_situation" class="form-control">
                <option value="default">Ordre par défaut</option>
                <option value="neg_to_pos">Par situation de - à +</option>
                <option value="pos_to_neg">Par situation de + à -</option>
            </select>
        </div>

        <div class="filter-group">
            <button type="button" class="btn btn-primary w-100">Lancer</button>
        </div>
    </div>

    <div class="paiements-list">
        <!-- Exemple de carte de paiement -->
        <div class="card-paiement">
            <h5>Paiement #12 - Immeuble 3</h5>
            <div class="card-body">
                <div class="card-field">
                    <strong>Numéro Port</strong>
                    <span>12</span>
                </div>
                <div class="card-field">
                    <strong>Nom/numéro Immeuble</strong>
                    <span>3</span>
                </div>
                <div class="card-field">
                    <strong>Nom Résidence</strong>
                    <span>1</span>
                </div>
                <div class="card-field">
                    <strong>Montant payé</strong>
                    <span>150 000 DH</span>
                </div>
                <div class="card-field">
                    <strong>Date opération</strong>
                    <span>25/05/2025</span>
                </div>
                <div class="card-field">
                    <strong>Mois payé</strong>
                    <span>Juin 2025</span>
                </div>
                <div class="card-field">
                    <strong>Prochain paiement</strong>
                    <span>25/06/2025</span>
                </div>
            </div>
        </div>

        <div class="card-paiement">
            <h5>Paiement #8 - Immeuble 2</h5>
            <div class="card-body">
                <div class="card-field">
                    <strong>Numéro Port</strong>
                    <span>8</span>
                </div>
                <div class="card-field">
                    <strong>Nom/numéro Immeuble</strong>
                    <span>2</span>
                </div>
                <div class="card-field">
                    <strong>Nom Résidence</strong>
                    <span>1</span>
                </div>
                <div class="card-field">
                    <strong>Montant payé</strong>
                    <span>130 000 DH</span>
                </div>
                <div class="card-field">
                    <strong>Date opération</strong>
                    <span>20/05/2025</span>
                </div>
                <div class="card-field">
                    <strong>Mois payé</strong>
                    <span>Juin 2025</span>
                </div>
                <div class="card-field">
                    <strong>Prochain paiement</strong>
                    <span>20/06/2025</span>
                </div>
            </div>
        </div>

        <div class="card-paiement">
            <h5>Paiement #20 - Immeuble 5</h5>
            <div class="card-body">
                <div class="card-field">
                    <strong>Numéro Port</strong>
                    <span>20</span>
                </div>
                <div class="card-field">
                    <strong>Nom/numéro Immeuble</strong>
                    <span>5</span>
                </div>
                <div class="card-field">
                    <strong>Nom Résidence</strong>
                    <span>2</span>
                </div>
                <div class="card-field">
                    <strong>Montant payé</strong>
                    <span>175 000 DH</span>
                </div>
                <div class="card-field">
                    <strong>Date opération</strong>
                    <span>18/05/2025</span>
                </div>
                <div class="card-field">
                    <strong>Mois payé</strong>
                    <span>Juin 2025</span>
                </div>
                <div class="card-field">
                    <strong>Prochain paiement</strong>
                    <span>18/06/2025</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection