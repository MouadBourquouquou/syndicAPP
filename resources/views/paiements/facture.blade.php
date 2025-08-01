<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Facture #{{ $paiement->id }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #ffffff;
            color: #333;
            font-size: 14px;
            line-height: 1.4;
        }

        .invoice-container {
            max-width: 800px;
            margin: auto;
    
        }

        /* Header */
        .header {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .header .logo {
            flex-shrink: 0;
        }

        .header .logo img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border-radius: 50%;
        }

        .header .company-info {
            text-align: center;
            flex: 1;
        }

        .header .company-info h1 {
            margin: 0 0 5px 0;
            font-size: 24px;
            color: #333;
            font-weight: 700;
        }

        .header .company-info .subtitle {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .header .invoice-details {
            flex-shrink: 0;
            text-align: right;
            background: white;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            min-width: 200px;
        }

        .header .invoice-details h2 {
            margin: 0 0 10px 0;
            color: #007bff;
            font-size: 18px;
        }

        .header .invoice-details p {
            margin: 5px 0;
            font-size: 13px;
        }

        /* Content */
        .invoice-body {
            padding: 30px;
        }

        h2.section-title {
            font-size: 16px;
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 2px;
            margin: 2px 0 2px 0;
            text-transform: uppercase;
            font-weight: 600;
        }

        h2.section-title:first-of-type {
            margin-top: 0;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
            border-bottom: 1px solid #ddd;
            width: 200px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        /* Months */
        .months-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: inline-flex;
            flex-direction: row;
            flex-wrap: nowrap;
            gap: 6px;
            overflow-x: auto;
            align-items: center;
            width: 100%;
        }

        .months-list li {
            background: #007bff;
            color: white;
            padding: 4px 10px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: 500;
            white-space: nowrap;
            flex-shrink: 0;
            display: inline-block;
        }
        

        /* Total */
        .total-amount {
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-left: 4px solid #28a745;
            padding: 20px;
            margin: 20px 0;
            text-align: right;
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        /* Contacts */
        .contacts {
            margin-top: 15px;
        }

        .contact-block {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
        }

        .contact-block h3 {
            margin: 0 0 15px 0;
            color: #333;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .contact-block p {
            margin: 8px 0;
            font-size: 13px;
            line-height: 1.4;
        }

        .contact-block p strong {
            color: #333;
            font-weight: 600;
            display: inline-block;
            min-width: 80px;
        }

        /* Footer */
        .footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 5px;
        }

        .footer p {
            margin: 5px 0;
            font-size: 12px;
        }

        .footer .contact-block {
            margin: 15px auto 0 auto;
            max-width: 400px;
            background: transparent;
        }

        .footer .contact-block h3 {
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        .footer .contact-block p {
            color: rgba(255, 255, 255, 0.9);
        }

        .footer .contact-block p strong {
            color: white;
        }

        /* Print */
        @media print {
            body {
                padding: 0;
            }

            .invoice-container {
                border: none;
                box-shadow: none;
            }

            .header {
                background: white !important;
            }
        }

        /* Mobile */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            .header .invoice-details {
                min-width: auto;
                width: 100%;
            }

            .invoice-body {
                padding: 20px;
            }

            th {
                width: auto;
            }

            .months-list {
                justify-content: flex-start;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <header class="header">
            <div class="invoice-details">
                <div class="logo">
                    <img src="{{ $logo ?? asset('images/logo.png') }}" alt="Logo Syndic" />
                    <div class="company-info">
                        <h2>Facture de paiement</h2>
                        <p><strong>Date:</strong> {{ $paiement->created_at->format('d/m/Y') }}</p>
                        <p><strong>N°:</strong> {{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>
            </div>
        </header>

        <div class="invoice-body">
            <section>
                <h2 class="section-title">Détails du Paiement</h2>
                <table>
                    <tr>
                        <th>Propriétaire</th>
                        <td>{{ $paiement->appartement->Nom }} {{ $paiement->appartement->Prenom }}</td>
                    </tr>
                    <tr>
                        <th>Immeuble</th>
                        <td>{{ $paiement->appartement->immeuble->nom }}</td>
                    </tr>
                    <tr>
                        <th>Résidence</th>
                        <td>
                            @if($residence)
                                {{ $residence->nom }}
                            @else
                                Non spécifiée
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Numéro d'appartement</th>
                        <td>{{ $paiement->appartement->numero }}</td>
                    </tr>
                    <tr>
                        <th>Mois payés - {{ implode(', ', $annees) }}</th>
                        <td>
                            <ul class="months-list">
                                @php
                                    // Fix: Handle both array and JSON string cases
                                    $moisPayes = [];
                                    if (is_array($paiement->mois_payes)) {
                                        $moisPayes = $paiement->mois_payes;
                                    } elseif (is_string($paiement->mois_payes)) {
                                        $moisPayes = json_decode($paiement->mois_payes, true) ?? [];
                                    } else {
                                        // Fallback data if null or other type
                                        $moisPayes = ["2025-04-01", "2025-05-01", "2025-06-01"];
                                    }
                                @endphp
                                @foreach($moisPayes as $mois)
                                    <li>{{ \Carbon\Carbon::parse($mois)->translatedFormat('F') }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                </table>

                <div class="total-amount">
                    @php
                        $montantMensuel = $paiement->appartement->montant_cotisation_mensuelle ?? 450;
                        $montantTotal = $montantMensuel * count($moisPayes);
                    @endphp
                    Montant total payé : {{ number_format($montantTotal, 2, ',', ' ') }} DH
                </div>
            </section>

            <section>
                <h2 class="section-title">Opération effectuée par :</h2>
                <div class="contacts">
                    <div class="contact-block">
                        @if(auth()->user()->statut === 'assistant_syndic')
                            <strong>Nom: {{ $assistant?->nom ?? 'Non disponible' }}</strong><br>
                            <strong>Email: {{ $assistant?->email ?? 'Non disponible' }}</strong><br>
                        @else
                            <strong> Nom: {{ $syndic?->name . ' ' . $syndic?->prenom }}</strong><br>
                            <strong> Email: {{ $syndic?->email ?? 'Non disponible' }}</strong><br>

                        @endif
                    </div>
                </div>
            </section>
        </div>

        <footer class="footer">
            <p>
                Merci pour votre paiement -
                {{ $residence ? 'Résidence ' . $residence->nom : 'Résidence inconnue' }}
            </p>

            <div class="contact-block">
                @if($syndic)
                    <h3>Bureau syndical</h3>
                    <p>Nom: {{ $syndic->name }} {{ $syndic->prenom }} 
                    <p>Email:{{ $syndic->email }}
                    - Adresse: {{ $syndic->adresse . ' ' . $syndic->ville }}</p>

                @else
                    <p><em>Aucun syndic trouvé.</em></p>
                @endif
            </div>
        </footer>
    </div>
</body>

</html>