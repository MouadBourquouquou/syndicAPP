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

        $immeubleIds = $user->immeubles()->select('immeuble.id')->pluck('id');

        $residenceIds = Immeuble::whereIn('id', $immeubleIds)
            ->whereNotNull('residence_id')
            ->pluck('residence_id')
            ->unique();

        $appartementIds = Appartement::whereIn('immeuble_id', $immeubleIds)->pluck('id_A');

        $creationDate = $user->created_at ?? now();
        $startMonth = Carbon::parse($creationDate)->startOfMonth();
        $currentMonth = Carbon::now()->startOfMonth();

        $months = [];
        $tempMonth = $startMonth->copy();
        while ($tempMonth->lessThanOrEqualTo($currentMonth)) {
            $months[] = $tempMonth->format('Y-m');
            $tempMonth->addMonth();
        }

        $month = $request->input('month', Carbon::now()->format('Y-m'));
        [$year, $monthNum] = explode('-', $month);
        $startDate = "$year-$monthNum-01";
        $endDate = date("Y-m-t", strtotime($startDate));

        $nbImmeubles = $immeubleIds->count();
        $nbAppartements = $appartementIds->count();
        $nbResidences = $residenceIds->count();
        $nbEmployes = 0;

        $totalPaiements = Paiement::whereIn('id_A', $appartementIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('montant');

        $totalCharges = Charge::whereIn('immeuble_id', $immeubleIds)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('montant');

        $totalSalaires = 0;
        $chiffreAffairesNet = $totalPaiements - $totalCharges;
        $caisseDisponible = $chiffreAffairesNet;

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

        $immeubleIds = $user->immeubles()->pluck('id');
        $appartementIds = Appartement::whereIn('immeuble_id', $immeubleIds)->pluck('id_A');

        $paiements = Paiement::with('appartement')
            ->whereIn('id_A', $appartementIds)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('assistant.historique', compact('paiements'));
    }
}
