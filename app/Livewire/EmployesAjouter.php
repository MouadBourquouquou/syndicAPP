<?php

namespace App\Livewire;

use Livewire\Component;

class EmployesAjouter extends Component
{
    public $nom;
    public $prenom;
    public $poste;
    public $message;

    public function ajouter()
    {
        $this->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'poste' => 'required|string|max:255',
        ]);

        // Simulation d'ajout sans base de données
        $this->message = "Employé '{$this->prenom} {$this->nom}' ajouté avec succès (simulation frontend).";

        // Réinitialiser les champs
        $this->nom = '';
        $this->prenom = '';
        $this->poste = '';
    }

    public function render()
    {
        return view('livewire.employes-ajouter');
    }
}
