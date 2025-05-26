@extends('layouts.app')

@section('content')
    <h1>Historique des paiements</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Historique</th>
                <th>ID Appartement</th>
                <th>ID Immeuble</th>
                <th>ID Résidence</th>
                <th>Montant payé</th>
                <th>Date de l’opération</th>
                <th>Date du prochain paiement</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>12</td>
                <td>3</td>
                <td>1</td>
                <td>150000</td>
                <td>2025-05-25</td>
                <td>2025-06-25</td>
            </tr>
            <tr>
                <td>2</td>
                <td>8</td>
                <td>2</td>
                <td>1</td>
                <td>130000</td>
                <td>2025-05-20</td>
                <td>2025-06-20</td>
            </tr>
            <tr>
                <td>3</td>
                <td>20</td>
                <td>5</td>
                <td>2</td>
                <td>175000</td>
                <td>2025-05-18</td>
                <td>2025-06-18</td>
            </tr>
        </tbody>
    </table>
@endsection
