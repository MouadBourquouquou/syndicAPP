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
        $userId = $user->id;

        $creationDate = $user->created_at ?? now();

        $startMonth = Carbon::parse($creationDate)->startOfMonth();
        $currentMonth = Carbon::now()->startOfMonth();

        $months = [];
        while ($startMonth->lessThanOrEqualTo($currentMonth)) {
            $months[] = $startMonth->format('Y-m');
            $startMonth->addMonth();
        }

        $month = $request->input('month', Carbon::now()->format('Y-m'));
        $year = substr($month, 0, 4);
        $monthNum = substr($month, 5, 2);
        $startDate = "$year-$monthNum-01";
        $endDate = date("Y-m-t", strtotime($startDate));

        $immeubleIds = Immeuble::where('id_S', $userId)->pluck('id');
        $appartementIds = Appartement::whereIn('immeuble_id', $immeubleIds)->pluck('id_A');

        $nbImmeubles = $immeubleIds->count();
        $nbAppartements = $appartementIds->count();
        $nbEmployes = Employe::where('id_S', $userId)->count();
        $nbResidences = Residence::where('id_S', $userId)->count();


        $totalPaiements = Paiement::whereIn('id_A', $appartementIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('montant');

        $totalCharges = Charge::whereIn('immeuble_id', $immeubleIds)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('montant');


        $totalSalaires = Employe::where('id_S', $userId)->sum('salaire');

        $chiffreAffairesNet = $totalPaiements - $totalCharges - $totalSalaires;
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
            'months' => $months,
        ]);
    }

    public function historique()
    {
        $userId = auth()->id();

        $immeubleIds = Immeuble::where('id_S', $userId)->pluck('id');
        $appartementIds = Appartement::whereIn('immeuble_id', $immeubleIds)->pluck('id');

        $paiements = Paiement::with(['appartement', 'charge'])
            ->whereIn('id_A', $appartementIds)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('historique', compact('paiements'));
    }
}
