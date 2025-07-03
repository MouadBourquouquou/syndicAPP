<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\Charge;
use App\Models\Appartement;
use App\Models\Immeuble;
use App\Models\Employe;
use App\Models\Residence;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Date de création du compte utilisateur connecté (syndic)
        $creationDate = $user->created_at ?? now();

        // 2. Générer la liste des mois depuis la création jusqu'au mois en cours
        $startMonth = Carbon::parse($creationDate)->startOfMonth();
        $currentMonth = Carbon::now()->startOfMonth();

        $months = [];
        while ($startMonth->lessThanOrEqualTo($currentMonth)) {
            $months[] = $startMonth->format('Y-m');
            $startMonth->addMonth();
        }

        // 3. Récupérer le mois sélectionné dans la requête ou défaut mois courant
        $month = $request->input('month', Carbon::now()->format('Y-m'));
        $year = substr($month, 0, 4);
        $monthNum = substr($month, 5, 2);

        // 4. Stats globales
        $nbImmeubles = Immeuble::count();
        $nbAppartements = Appartement::count();
        $nbEmployes = Employe::count();
        $nbResidences = Residence::count();

        // 5. Calcul des plages de dates du mois choisi
        $startDate = "$year-$monthNum-01";
        $endDate = date("Y-m-t", strtotime($startDate)); // dernier jour du mois

        // 6. Total des paiements reçus dans ce mois
        $totalPaiements = Paiement::whereBetween('created_at', [$startDate, $endDate])->sum('montant');

        // 7. Total des charges dans ce mois
        $totalCharges = Charge::whereBetween('date', [$startDate, $endDate])->sum('montant');

        // 8. Total des salaires des employés (fixe mensuel ici)
        $totalSalaires = Employe::sum('salaire');

        // 9. Calcul du chiffre d'affaires net = paiements - charges - salaires
        $chiffreAffairesNet = $totalPaiements - $totalCharges - $totalSalaires;

        // 10. Caisse disponible (ici égale au chiffre d'affaires net)
        $caisseDisponible = $chiffreAffairesNet;

        // 11. Charges par immeuble
        $chargesImmeubles = Charge::select('immeuble_id', DB::raw('SUM(montant) as total'))
            ->whereBetween('date', [$startDate, $endDate])
            ->groupBy('immeuble_id')
            ->get()
            ->mapWithKeys(function ($item) {
                $immeuble = Immeuble::find($item->immeuble_id);
                $name = $immeuble ? ($immeuble->nom ?? "Immeuble #{$item->immeuble_id}") : "Immeuble #{$item->immeuble_id}";
                return [$name => $item->total];
            });

        // 12. Passe la liste des mois générée à la vue au lieu de "moisDisponibles"
        return view('dashboard', [
            'nbImmeubles' => $nbImmeubles,
            'nbAppartements' => $nbAppartements,
            'nbEmployes' => $nbEmployes,
            'nbResidences' => $nbResidences,
            'totalPaiements' => $totalPaiements,
            'totalCharges' => $totalCharges,
            'totalSalaires' => $totalSalaires,
            'chiffreAffairesNet' => $chiffreAffairesNet,
            'caisseDisponible' => $caisseDisponible,
            'chargesImmeubles' => $chargesImmeubles,
            'month' => $month,
            'months' => $months, // liste des mois depuis création compte
        ]);
    }

    public function historique()
    {
        $paiements = Paiement::with(['appartement', 'charge'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('historique', compact('paiements'));
    }
}
