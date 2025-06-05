<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Facture #{{ $paiement->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .header h1 {
            margin-bottom: 10px;
            font-size: 24px;
            color: #2c3e50;
        }
        .details {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .details th, .details td {
            padding: 12px 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
            font-size: 14px;
        }
        .details th {
            background-color: #f5f5f5;
            width: 35%;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 13px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 15px;
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
            <td>
                {{ $paiement->appartement->Nom ?? 'N/A' }}
                {{ $paiement->appartement->Prenom ?? '' }}
            </td>
        </tr>
        <tr>
            <th>Numéro d'appartement</th>
            <td>{{ $paiement->appartement->numero ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Montant payé</th>
            <td>{{ number_format($paiement->montant, 2, ',', ' ') }} MAD</td>
        </tr>
        <tr>
            <th>Mois payé</th>
            <td>{{ \Carbon\Carbon::parse($paiement->mois_paye)->translatedFormat('F Y') }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>Merci pour votre paiement.<br> 
           Syndic de copropriété - <em>Votre société ou nom ici</em>
        </p>
    </div>
</body>
</html>
