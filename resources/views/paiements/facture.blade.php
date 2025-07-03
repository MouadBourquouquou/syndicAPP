<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Facture #{{ $paiement->id }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f7fa;
            color: #333;
            font-size: 16px;
            line-height: 1.6;
        }

        .invoice-container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border: 1px solid #ddd;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .header .logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header .logo img {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }

        .header h1 {
            font-weight: 700;
            font-size: 26px;
            color: #007bff;
            margin: 0;
        }

        .header .date {
            font-size: 15px;
            color: #555;
            font-weight: 600;
        }

        /* Section titles */
        .section-title {
            font-size: 22px;
            color: #007bff;
            font-weight: 700;
            margin: 30px 0 15px;
            border-bottom: 3px solid #cce0ff;
            padding-bottom: 10px;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
            margin-bottom: 40px;
        }

        th, td {
            padding: 14px 20px;
            background: #f0f6ff;
            border-radius: 8px;
            text-align: left;
            color: #1a1a1a;
        }

        th {
            background: #cce0ff;
            font-weight: 700;
            color: #0056b3;
        }

        ul.months-list {
            list-style: none;
            padding-left: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 8px 15px;
            margin: 0;
        }

        ul.months-list li {
            background: #d0e3ff;
            color: #004a99;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
        }

        /* Montant total */
        .total-amount {
            text-align: right;
            font-size: 28px;
            font-weight: 800;
            color: #007bff;
            border-top: 3px solid #cce0ff;
            padding-top: 20px;
            margin-top: 0;
            letter-spacing: 0.03em;
        }

        /* Contacts */
        .contacts {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            flex-wrap: wrap;
        }

        .contact-block {
            flex: 1 1 45%;
            background: #e7f0ff;
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: inset 0 0 10px rgba(0,123,255,0.1);
            color: #003366;
            font-weight: 600;
            min-width: 280px;
        }

        .contact-block h3 {
            margin-top: 0;
            font-weight: 800;
            margin-bottom: 15px;
            font-size: 20px;
            border-bottom: 2px solid #a8c4ff;
            padding-bottom: 10px;
        }

        .contact-block p {
            margin: 8px 0;
            font-size: 16px;
        }

        .contact-block p strong {
            color: #0056b3;
        }

        /* Footer */
        .footer {
            text-align: center;
            font-size: 14px;
            color: #666;
            border-top: 1px solid #cce0ff;
            padding-top: 25px;
            margin-top: 50px;
        }

        .footer em {
            font-style: normal;
            font-weight: 700;
            color: #007bff;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            .contacts {
                flex-direction: column;
            }
            .contact-block {
                flex: 1 1 100%;
                min-width: auto;
            }
            .total-amount {
                font-size: 24px;
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <header class="header">
            <div class="logo">
                <img src="{{ $logoUrl ?? 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/29/Laravel.svg/1200px-Laravel.svg.png' }}" alt="Logo">
                <h1>Facture de Paiement</h1>
            </div>
            <div class="date">
                Date de Paiement : <strong>{{ $paiement->created_at->format('d/m/Y') }}</strong>
            </div>
        </header>

        <section>
            <h2 class="section-title">Détails du Paiement</h2>
            <table>
                <tr>
                    <th>Nom du Propriétaire</th>
                    <td>{{ $paiement->appartement->Nom ?? 'N/A' }} {{ $paiement->appartement->Prenom ?? '' }}</td>
                </tr>
                <tr>
                    <th>Numéro d'appartement</th>
                    <td>{{ $paiement->appartement->numero ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Mois payés</th>
                    <td>
                        <ul class="months-list">
                            @php
                                $moisPayes = json_decode($paiement->mois_payes ?? '[]', true);
                            @endphp
                            @foreach($moisPayes as $mois)
                                <li>{{ \Carbon\Carbon::parse($mois)->translatedFormat('F Y') }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            </table>

            <p class="total-amount">
                @php
                    $montantMensuel = $paiement->appartement->montant_cotisation_mensuelle ?? 0;
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
                    <p><strong>Nom :</strong> {{ optional($paiement->user)->name ?? 'N/A' }} {{ optional($paiement->user)->prenom ?? '' }}</p>
                    <p><strong>Téléphone :</strong> {{ optional($paiement->user)->tel ?? 'N/A' }}</p>
                    <p><strong>Email :</strong> {{ optional($paiement->user)->email ?? 'N/A' }}</p>
                </div>
                <div class="contact-block">
                    <h3>Assistant Syndic</h3>
                    <p><strong>Nom :</strong> {{ $assistant->nom ?? 'N/A' }}</p>
                    <p><strong>Téléphone :</strong> {{ $assistant->tel ?? 'N/A' }}</p>
                    <p><strong>Email :</strong> {{ $assistant->email ?? 'N/A' }}</p>
                </div>
            </div>
        </section>

        <footer class="footer">
            <p>Merci pour votre paiement.<br>
            Syndic de copropriété - <em>{{ $societe ?? 'Votre société ou nom ici' }}</em></p>
        </footer>
    </div>
</body>
</html>
