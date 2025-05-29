@extends('layouts.app')

@section('content')
    <h1>Historique des paiements</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                
                <th>Numero Port</th>
                <th>Nom/numero Immeuble</th>
                <th>Nom Résidence</th>
                <th>Montant payé</th>
                <th>Date de l’opération</th>
                <th> mois payé</th>
                <th>Date du prochain paiement</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                
                <td>12</td>
                <td>3</td>
                <td>1</td>
                <td>150000</td>
                <td>2025-05-25</td>
                <td>2025-06-25</td>
            </tr>
            <tr>
                
                <td>8</td>
                <td>2</td>
                <td>1</td>
                <td>130000</td>
                <td>2025-05-20</td>
                <td>2025-06-20</td>
            </tr>
            <tr>
                
                <td>20</td>
                <td>5</td>
                <td>2</td>
                <td>175000</td>
                <td>2025-05-18</td>
                <td>2025-06-18</td>
            </tr>
            
        </tbody>
    </table>
    <div class="row mt-4 justify-content-end text-end">
            <div class="col-md-3">
                <select id="filtre_appartements" class="form-control">
                    <option value="tous">tous les appartements</option>
                    <option value="retard">en retard de paiement</option>
                    <option value="avance">paiement en avance</option>
                </select>
            </div>

            <div class="col-md-3">
                <select id="tri_situation" class="form-control">
                    <option value="default">ordre par défaut</option>
                    <option value="neg_to_pos">Par situation de - à +</option>
                    <option value="pos_to_neg">Par situation de + à -</option>
                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-primary w-100">Lancer</button>
            </div>
@endsection
