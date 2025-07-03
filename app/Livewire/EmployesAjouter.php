<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employe;

class EmployesAjouter extends Component
{
    public $nom;
    public $prenom;
    public $poste;
    public $email;
    public $telephone;
    public $ville;
    public $adresse;
    public $immeuble_id;
    public $residence_id;
    public $date_embauche;
    public $salaire;

    public $message;

    public function ajouter()
    {
        $this->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'poste' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'ville' => 'nullable|string|max:100',
            'adresse' => 'nullable|string|max:255',
            'immeuble_id' => 'nullable|integer|exists:immeuble,id',
            'residence_id' => 'nullable|integer|exists:residences,id',
            'date_embauche' => 'nullable|date',
            'salaire' => 'nullable|numeric|min:0',
        ]);

        Employe::create([
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'ville' => $this->ville,
            'adresse' => $this->adresse,
            'poste' => $this->poste,
            'immeuble_id' => $this->immeuble_id,
            'residence_id' => $this->residence_id,
            'date_embauche' => $this->date_embauche,
            'salaire' => $this->salaire,
        ]);

        $this->message = "Employé '{$this->prenom} {$this->nom}' ajouté avec succès.";

        // Réinitialiser les champs
        $this->reset([
            'nom', 'prenom', 'poste', 'email', 'telephone',
            'ville', 'adresse', 'immeuble_id', 'residence_id',
            'date_embauche', 'salaire'
        ]);
    }

    public function render()
    {
        return view('livewire.employes-ajouter');
    }
}
