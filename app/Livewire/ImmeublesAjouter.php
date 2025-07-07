<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Immeuble;
use App\Models\Residence;

class ImmeublesAjouter extends Component
{
    public $nom;
    public $ville;
    public $code_postal;
    public $adresse;
    public $cotisation;
    public $caisse;
    public $residence_id;
    public $a_residence = 'non'; // champ pour savoir si l'immeuble appartient à une résidence

    public $villes= ['Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger', 'Agadir', 'Meknès', 'Oujda', 'Kenitra', 'Temara'];

    public $residences = []; // <- on ajoute ceci

    public function mount()
    {
        $this->residences = Residence::where('id_S', auth()->id())->get();
        if ($this->residences->isEmpty()) {
            session()->flash('error', 'Veuillez d\'abord créer une résidence.');
            return redirect()->route('residences.create');
        }
    }

    protected function rules()
    {
        return [
            'nom' => 'required|string|max:255',
            'a_residence' => 'required|in:oui,non',
            'residence_id' => 'required_if:a_residence,oui|nullable|exists:residences,id',
            'ville' => 'required_if:a_residence,non|string|max:255',
            'code_postal' => 'required_if:a_residence,non|numeric',
            'adresse' => 'required_if:a_residence,non|string|max:255',
            'cotisation' => 'required|numeric|min:0',
            'caisse' => 'required_if:a_residence,non|numeric|min:0',
        ];
    }

    public function ajouter()
    {
        $this->validate();

        $data = [
            'nom' => $this->nom,
            'cotisation' => $this->cotisation,
        ];

        if ($this->a_residence === 'oui') {
            $data['residence_id'] = $this->residence_id;
            $data['ville'] = null;
            $data['code_postal'] = null;
            $data['adresse'] = null;
            $data['caisse'] = null;
        } else {
            $data['residence_id'] = null;
            $data['ville'] = $this->ville;
            $data['code_postal'] = $this->code_postal;
            $data['adresse'] = $this->adresse;
            $data['caisse'] = $this->caisse;
        }

        Immeuble::create($data);

        session()->flash('success', 'Immeuble ajouté avec succès !');

        $this->reset([
            'nom', 'ville', 'code_postal', 'adresse', 'cotisation', 'caisse', 'residence_id', 'a_residence'
        ]);
        $this->resetValidation();
    }
    public function render()
{
    return view('livewire.immeubles-ajouter')
        ->layout('layouts.app');  // <- Ici Livewire cherche cette vue Blade
}

}
