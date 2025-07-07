<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Residence;
use App\Models\Immeuble;

class ImmeublesAjouter extends Component
{
    public $residences;
    public $villes;

    // Champs du formulaire
    public $a_residence = 'non';
    public $residence_id;
    public $nom;
    public $ville;
    public $code_postal;
    public $adresse;
    public $nombre_app;
    public $cotisation;
    public $caisse;

    protected $rules = [
        'a_residence'     => 'required|in:oui,non',
        'residence_id'    => 'nullable|exists:residences,id',
        'nom'             => 'required|string|max:255',
        'ville'           => 'required_if:a_residence,non|string|max:255',
        'code_postal'     => 'required_if:a_residence,non|numeric|digits_between:4,10',
        'adresse'         => 'required_if:a_residence,non|string|max:255',
        'nombre_app'      => 'required|integer|min:0',
        'cotisation'      => 'required|numeric|min:0',
        'caisse'          => 'required_if:a_residence,non|numeric|min:0',
    ];

    public function mount()
    {
        $this->residences = Residence::all();
        $this->$villes=['Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger', 'Agadir', 'Meknès', 'Oujda', 'Kenitra', 'Temara'];

    }

    public function submit()
    {
        $this->validate();

        $data = [
            'nom'        => $this->nom,
            'cotisation' => $this->cotisation,
            'nombre_app' => $this->nombre_app,
        ];

        if ($this->a_residence === 'oui') {
            $data['residence_id'] = $this->residence_id ?? null;
            $data['ville'] = $data['code_postal'] = $data['adresse'] = $data['caisse'] = null;
        } else {
            $data['residence_id'] = null;
            $data['ville']        = $this->ville;
            $data['code_postal']  = $this->code_postal;
            $data['adresse']      = $this->adresse;
            $data['caisse']       = $this->caisse;
        }

        Immeuble::create($data);

        session()->flash('success', 'Immeuble ajouté avec succès.');

        $this->reset([
            'a_residence', 'residence_id', 'nom', 'ville', 'code_postal',
            'adresse', 'nombre_app', 'cotisation', 'caisse'
        ]);
    }

    public function render()
    {
        return view('livewire.immeubles-ajouter');
    }
}
