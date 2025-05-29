<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Immeuble;
use App\Models\Residence;

class ImmeubleAjout extends Component
{
    public $nom;
    public $ville;
    public $code_postal;
    public $adresse;
    public $cotisation;
    public $caisse;
    public $residence_id;
    public $a_residence = 'non'; // champ pour savoir si appartient à résidence ou pas

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

        $this->reset(['nom', 'ville', 'code_postal', 'adresse', 'cotisation', 'caisse', 'residence_id', 'a_residence']);
        $this->resetValidation();
    }

    public function render()
    {
        $villes = ['Casablanca', 'Rabat', 'Marrakech'];
        $residences = Residence::all();

        return view('livewire.immeuble-ajouter', compact('villes', 'residences'));
    }
}
