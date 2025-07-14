<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Immeuble;
use App\Models\Appartement;
use App\Models\Paiement;
use App\Models\Charge;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Get immeubles assigned to this assistant through employe_immeuble pivot
        $immeubleIds = $user->immeubles()->pluck('immeuble.id');
        
        // Get residences related to these immeubles
        $residenceIds = Immeuble::whereIn('id', $immeubleIds)
            ->whereNotNull('residence_id')
            ->pluck('residence_id')
            ->unique();
            
        // Get appartements in these immeubles
        $appartementIds = Appartement::whereIn('immeuble_id', $immeubleIds)->pluck('id_A');

        // 2. Generate months list since account creation
        $creationDate = $user->created_at ?? now();
        $startMonth = Carbon::parse($creationDate)->startOfMonth();
        $currentMonth = Carbon::now()->startOfMonth();

        $months = [];
        while ($startMonth->lessThanOrEqualTo($currentMonth)) {
            $months[] = $startMonth->format('Y-m');
            $startMonth->addMonth();
        }

        // 3. Selected period
        $month = $request->input('month', Carbon::now()->format('Y-m'));
        [$year, $monthNum] = explode('-', $month);
        $startDate = "$year-$monthNum-01";
        $endDate = date("Y-m-t", strtotime($startDate));

        // 4. Statistics - only for assigned immeubles
        $nbImmeubles = $immeubleIds->count();
        $nbAppartements = $appartementIds->count();
        $nbResidences = $residenceIds->count(); // Only residences related to assigned immeubles
        $nbEmployes = 0; // Assistant doesn't manage employees

        // Payments for appartements in assigned immeubles
        $totalPaiements = Paiement::whereIn('id_A', $appartementIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('montant');

        // Charges for assigned immeubles
        $totalCharges = Charge::whereIn('immeuble_id', $immeubleIds)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('montant');

        // No salary calculation for assistant
        $totalSalaires = 0;
        $chiffreAffairesNet = $totalPaiements - $totalCharges;
        $caisseDisponible = $chiffreAffairesNet;

        // 5. Charges by immeuble (only assigned ones)
        $chargesImmeubles = Charge::whereIn('immeuble_id', $immeubleIds)
            ->whereBetween('date', [$startDate, $endDate])
            ->select('immeuble_id', DB::raw('SUM(montant) as total'))
            ->groupBy('immeuble_id')
            ->get()
            ->mapWithKeys(function ($item) {
                $immeuble = Immeuble::find($item->immeuble_id);
                $nom = $immeuble ? ($immeuble->nom ?? "Immeuble #{$item->immeuble_id}") : "Immeuble #{$item->immeuble_id}";
                return [$nom => $item->total];
            });

        return view('assistant.dashboard', compact(
            'months', 'month',
            'nbImmeubles', 'nbAppartements', 'nbResidences', 'nbEmployes',
            'totalPaiements', 'totalCharges', 'totalSalaires',
            'chiffreAffairesNet', 'caisseDisponible', 'chargesImmeubles'
        ));
    }

    public function historique()
    {
        $user = Auth::user();

        // Get only immeubles assigned to this assistant
        $immeubleIds = $user->immeubles()->pluck('immeuble.id');
        $appartementIds = Appartement::whereIn('immeuble_id', $immeubleIds)->pluck('id_A');

        // Get payments only for assigned appartements
        $paiements = Paiement::with(['appartement', 'charge'])
            ->whereIn('id_A', $appartementIds)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('assistant.historique', compact('paiements'));
    }
}