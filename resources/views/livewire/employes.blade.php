@extends('layouts.app')

@section('title', 'Liste des employés')

@push('styles')
<style>
    .btn {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 500;
        color: white;
        border: none;
        cursor: pointer;
        white-space: nowrap;
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

    .table thead {
        background-color: #f9fafb;
    }

    .table th, .table td {
        vertical-align: middle !important;
        max-width: 150px; /* Largeur max contrôlée */
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap; /* Pas de retour à la ligne */
    }

    /* Colonne Actions : largeur plus large et boutons côte à côte */
    .table td:last-child, .table th:last-child {
        max-width: none;
        white-space: nowrap;
        width: 180px;
    }

    /* Conteneur pour scroll horizontal si nécessaire */
    .table-responsive {
        overflow-x: auto;
        width: 100%;
        -webkit-overflow-scrolling: touch;
    }

    /* Actions alignées horizontalement */
    .table td:last-child {
        display: flex;
        justify-content: center;
        gap: 6px;
    }
</style>
@endpush

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Liste des employés</h4>
        <a href="{{ url('/employes/ajouter') }}" class="btn btn-success">+ Ajouter un employé</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover shadow-sm bg-white">
            <thead class="text-center">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email professionnel</th>
                    <th>Téléphone</th>
                    <th>Poste / Fonction</th>
                    <th>Date d'embauche</th>
                    <th>Salaire</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <td>Jean</td>
                    <td>Dupont</td>
                    <td>jean.dupont@example.com</td>
                    <td>+33 6 12 34 56 78</td>
                    <td>Comptable</td>
                    <td>15/01/2020</td>
                    <td>15,000 DH</td>
                    <td>
                        <button class="btn btn-view">👁 Voir</button>
                        <button class="btn btn-edit">✏️ Modifier</button>
                        <button class="btn btn-delete">🗑 Supprimer</button>
                    </td>
                </tr>
                <tr>
                    <td>Marie</td>
                    <td>Durand</td>
                    <td>marie.durand@example.com</td>
                    <td>+33 6 98 76 54 32</td>
                    <td>Secrétaire</td>
                    <td>03/05/2018</td>
                    <td>12,500 DH</td>
                    <td>
                        <button class="btn btn-view">👁 Voir</button>
                        <button class="btn btn-edit">✏️ Modifier</button>
                        <button class="btn btn-delete">🗑 Supprimer</button>
                    </td>
                </tr>
                <tr>
                    <td>Ahmed</td>
                    <td>Benali</td>
                    <td>ahmed.benali@example.com</td>
                    <td>+212 6 11 22 33 44</td>
                    <td>Technicien</td>
                    <td>20/07/2022</td>
                    <td>10,000 DH</td>
                    <td>
                        <button class="btn btn-view">👁 Voir</button>
                        <button class="btn btn-edit">✏️ Modifier</button>
                        <button class="btn btn-delete">🗑 Supprimer</button>
                    </td>
                </tr>
                <!-- Ajoutez d'autres lignes statiques ici si besoin -->
            </tbody>
        </table>
    </div>
</div>
@endsection
