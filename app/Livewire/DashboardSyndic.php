<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Utilisateur;
use App\Models\Immeuble;

class DashboardSyndic extends Component
{
    public $syndicEmail;

    public function mount()
    {
        // Supposons que le syndic est l'utilisateur connecté
        $this->syndicEmail = auth()->user()->email;
    }

    public function render()
    {
        $immeubles = Immeuble::where('syndic_email', $this->syndicEmail)->get();

        return view('livewire.dashboard-syndic', [
            'immeubles' => $immeubles
        ]);
    }
}
