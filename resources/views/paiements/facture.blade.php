<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Facture #{{ $paiement->id }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        body {
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #fff;
            color: #000;
            font-size: 13px;
        }

        .invoice-container {
            max-width: 780px;
            margin: auto;
            border: 1px solid #ccc;
            padding: 20px;
            box-sizing: border-box;
            page-break-inside: avoid;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #1d3557;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header .logo img {
            width: 60px;
        }

        .header .title h1 {
            margin: 0;
            font-size: 18px;
            color: #1d3557;
        }

        .header .title p {
            margin: 4px 0;
        }

        h2.section-title {
            font-size: 16px;
            color: #1d3557;
            border-bottom: 1px solid #cfd8dc;
            padding-bottom: 4px;
            margin-top: 25px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
            font-size: 13px;
        }

        th {
            background-color: #f1f5f9;
            font-weight: 600;
        }

        .months-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .months-list li {
            background: #e1ecf7;
            color: #1d3557;
            padding: 3px 7px;
            border-radius: 4px;
            font-size: 12px;
        }

        .total-amount {
            text-align: right;
            margin-top: 20px;
            font-size: 15px;
            font-weight: 600;
            color: #1d3557;
        }

        .contacts {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .contact-block {
            width: 48%;
            background: #f9f9f9;
            border: 1px solid #ccc;
            padding: 10px 15px;
            box-sizing: border-box;
        }

        .contact-block h3 {
            margin-top: 0;
            color: #1d3557;
            font-size: 14px;
            border-bottom: 1px solid #cfd8dc;
            padding-bottom: 3px;
        }

        .contact-block p {
            margin: 5px 0;
            font-size: 13px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #555;
            margin-top: 30px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        @media print {
            html, body {
                height: 100%;
                max-height: 100%;
                margin: 0;
                padding: 0;
            }

            .invoice-container,
            .section-title,
            .contacts,
            .contact-block,
            table,
            .total-amount,
            .footer {
                page-break-inside: avoid;
            }

            .invoice-container {
                box-shadow: none;
                border: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <header class="header">
            <div class="logo">
                <img src="{{ $logoUrl ?? 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/29/Laravel.svg/1200px-Laravel.svg.png' }}" alt="Logo">
            </div>
            <div class="title">
                <h1>Facture de Paiement</h1>
                <p>Date : <strong>{{ $paiement->created_at->format('d/m/Y') }}</strong></p>
                <p>Facture N° : {{ $paiement->id }}</p>
            </div>
        </header>

        <section>
            <h2 class="section-title">Détails du Paiement</h2>
            <table>
                <tr>
                    <th>Nom du Propriétaire</th>
                    <td>{{ $paiement->appartement->Nom ?? 'Ait El Kadi' }} {{ $paiement->appartement->Prenom ?? 'Samir' }}</td>
                </tr>
                <tr>
                    <th>Numéro d'appartement</th>
                    <td>{{ $paiement->appartement->numero ?? 'B12' }}</td>
                </tr>
                <tr>
                    <th>Mois payés</th>
                    <td>
                        <ul class="months-list">
                            @php
                                $moisPayes = json_decode($paiement->mois_payes ?? '["2025-04-01","2025-05-01","2025-06-01"]', true);
                            @endphp
                            @foreach(array_slice($moisPayes, 0, 4) as $mois)
                                <li>{{ \Carbon\Carbon::parse($mois)->translatedFormat('F Y') }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            </table>

            <p class="total-amount">
                @php
                    $montantMensuel = $paiement->appartement->montant_cotisation_mensuelle ?? 450;
                    $montantTotal = $montantMensuel * count($moisPayes);
                @endphp
                Montant total payé : {{ number_format($montantTotal, 2, ',', ' ') }} MAD
            </p>
        </section>

        <section>
            <h2 class="section-title">Coordonnées</h2>
            <div class="contacts">
                <div class="contact-block">
                    <h3>Syndic</h3>
                    <p><strong>Nom :</strong> {{ optional($paiement->user)->name ?? 'Hassan' }} {{ optional($paiement->user)->prenom ?? 'Bennani' }}</p>
                    <p><strong>Téléphone :</strong> {{ optional($paiement->user)->tel ?? '06 78 12 34 56' }}</p>
                    <p><strong>Email :</strong> {{ optional($paiement->user)->email ?? 'hassan.bennani@syndic.ma' }}</p>
                </div>
                <div class="contact-block">
                    <h3>Assistant Syndic</h3>
                    <p><strong>Nom :</strong> {{ $assistant->nom ?? 'Leila Akhchichine' }}</p>
                    <p><strong>Téléphone :</strong> {{ $assistant->tel ?? '06 98 76 54 32' }}</p>
                    <p><strong>Email :</strong> {{ $assistant->email ?? 'leila.akhchichine@syndic.ma' }}</p>
                </div>
            </div>
        </section>

        <footer class="footer">
            <p>Merci pour votre paiement. <br>Syndic — <strong>{{ $societe ?? 'Résidence Les Palmiers' }}</strong></p>
        </footer>
    </div>
</body>
</html>
