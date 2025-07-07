<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historique;
use Illuminate\Support\Facades\Auth;

class HistoriqueController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Only get payment records (where montant_paye > 0)
        $paiements = Historique::where('id_A', $userId)
            ->where('montant_paye', '>', 0)
            ->orderByDesc('annee')
            ->orderByDesc('mois')
            ->get();

        return view('historique.index', [
            'paiements' => $paiements->map(function($paiement) {
                return [
                    'appartement' => [
                        'numero' => $paiement->appartement_numero ?? '-',
                        'immeuble' => [
                            'nom' => $paiement->immeuble_nom ?? '-',
                            'residence' => [
                                'nom' => $paiement->residence_nom ?? '-'
                            ]
                        ]
                    ],
                    'mois_payes' => json_encode([$paiement->annee.'-'.str_pad($paiement->mois, 2, '0', STR_PAD_LEFT)]),
                    'montant' => $paiement->montant_paye
                ];
            })
        ]);
    }

    // Method to log only payments
    public static function logPayment($userId, $montant, $mois, $annee, $details = '')
    {
        return Historique::create([
            'id_A' => $userId,
            'mois' => $mois,
            'annee' => $annee,
            'montant_paye' => $montant,
            'recu' => json_encode([
                'type' => 'paiement',
                'details' => $details,
                'timestamp' => now()->toDateTimeString()
            ])
        ]);
    }
}