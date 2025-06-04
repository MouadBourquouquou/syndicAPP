<!DOCTYPE html>
<html>
<head>
    <title>Facture #{{ $paiement->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .header h1 {
            margin-bottom: 10px;
        }
        .details {
            width: 100%;
            border-collapse: collapse;
        }
        .details th, .details td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Facture de Paiement</h1>
        <p><strong>Date de Paiement :</strong> {{ \Carbon\Carbon::parse($paiement->mois_paye)->format('d/m/Y') }}</p>
    </div>

    <table class="details">
        <tr>
            <th>Nom du Propriétaire</th>
            <td>{{ $paiement->appartement->Nom ?? 'N/A' }} {{ $paiement->appartement->Prenom ?? '' }}</td>
        </tr>
        <tr>
            <th>Numéro d'appartement</th>
            <td>{{ $paiement->appartement->numero ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Montant payé</th>
            <td>{{ number_format($paiement->montant, 2) }} MAD</td>
        </tr>
        <tr>
            <th>Mois payé</th>
            <td>{{ \Carbon\Carbon::parse($paiement->mois_paye)->format('F Y') }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>Merci pour votre paiement.</p>
    </div>
</body>
</html>
