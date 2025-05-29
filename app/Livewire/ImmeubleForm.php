<?php

namespace App\Livewire;

use App\Models\Immeuble;
use Livewire\Component;

class ImmeubleForm extends Component
{
    public $nom;
    public $ville;
    public $code_postal;
    public $adresse;
    public $nombre_app;
    public $cotisation;
    public $caisse;
    public $residence_id;
    public $a_residence = 'non'; // ajouter ce champ pour gérer la condition résidence/non

    protected function rules()
    {
        return [
            'nom' => 'required|string|max:255',
            'a_residence' => 'required|in:oui,non',
            'residence_id' => 'nullable|exists:residences,id',
            'ville' => 'required_if:a_residence,non|string|max:255',
            'code_postal' => 'required_if:a_residence,non|string|max:10',
            'adresse' => 'required_if:a_residence,non|string|max:255',
            'nombre_app' => 'required|integer|min:0',
            'cotisation' => 'required|numeric|min:0',
            'caisse' => 'required_if:a_residence,non|numeric|min:0',
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();

        // Préparer les données à insérer selon résidence ou pas
        $data = [
            'nom' => $validatedData['nom'],
            'nombre_app' => $validatedData['nombre_app'],
            'cotisation' => $validatedData['cotisation'],
        ];

        if ($validatedData['a_residence'] === 'oui') {
            $data['residence_id'] = $validatedData['residence_id'] ?? null;
            $data['ville'] = null;
            $data['code_postal'] = null;
            $data['adresse'] = null;
            $data['caisse'] = null;
        } else {
            $data['residence_id'] = null;
            $data['ville'] = $validatedData['ville'];
            $data['code_postal'] = $validatedData['code_postal'];
            $data['adresse'] = $validatedData['adresse'];
            $data['caisse'] = $validatedData['caisse'];
        }

        Immeuble::create($data);

        session()->flash('success', 'Immeuble ajouté avec succès.');

        // Redirection après sauvegarde (à adapter)
        return redirect()->to('/appartements/ajouter');
    }

    public function render()
    {
        return view('livewire.immeuble-form');
    }
}
