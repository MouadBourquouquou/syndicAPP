<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Employe;
use App\Models\Residence;
use App\Models\Immeuble;
use Illuminate\Validation\Rule;

class Employes extends Component
{
    use WithPagination;

    public $residences, $immeubles;
    public $nom, $prenom, $email, $telephone, $ville, $adresse, $poste, $residence_id, $date_embauche, $salaire;
    public $immeuble = [];
    public $employeId;
    public $isEdit = false;

    public function mount()
    {
        $this->residences = Residence::all();
        $this->immeubles = Immeuble::all();
    }

    // In your Employes Livewire component
public function render()
{
    $employes = Employe::with(['immeubles', 'residence'])->paginate(10);
    $appartements = \App\Models\Appartement::with('immeuble')->get(); // Add this line
    
    return view('livewire.employes', compact('employes', 'appartements')); // Add to compact
}

    public function resetForm()
    {
        $this->reset(['nom', 'prenom', 'email', 'telephone', 'ville', 'adresse', 'poste', 'residence_id', 'date_embauche', 'salaire', 'immeuble', 'employeId', 'isEdit']);
    }

    public function rules()
    {
        return [
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => ['required', 'email', Rule::unique('employes', 'email')->ignore($this->employeId)],
            'telephone' => 'nullable|string|max:20',
            'ville' => 'nullable|string|max:100',
            'adresse' => 'nullable|string|max:256',
            'poste' => 'required|in:assistant_syndic,concierge,femme_menage',
            'residence_id' => 'nullable|exists:residences,id',
            'immeuble' => 'nullable|array',
            'immeuble.*' => 'exists:immeuble,id',
            'date_embauche' => 'required|date',
            'salaire' => 'nullable|numeric|min:0',
        ];
    }

    public function save()
    {
        $this->validate();

        $employe = Employe::updateOrCreate(
            ['id' => $this->employeId],
            [
                'nom' => $this->nom,
                'prenom' => $this->prenom,
                'email' => $this->email,
                'telephone' => $this->telephone,
                'ville' => $this->ville,
                'adresse' => $this->adresse,
                'poste' => $this->poste,
                'residence_id' => $this->residence_id,
                'date_embauche' => $this->date_embauche,
                'salaire' => $this->salaire ?? 0,
            ]
        );

        $employe->immeubles()->sync($this->immeuble ?? []);

        session()->flash('success', $this->isEdit ? 'Employé mis à jour avec succès.' : 'Employé ajouté avec succès.');

        $this->resetForm();
    }

    public function edit($id)
    {
        $employe = Employe::with('immeubles')->findOrFail($id);

        $this->fill($employe->only(['nom', 'prenom', 'email', 'telephone', 'ville', 'adresse', 'poste', 'residence_id', 'date_embauche', 'salaire']));
        $this->immeuble = $employe->immeubles->pluck('id')->toArray();
        $this->employeId = $employe->id;
        $this->isEdit = true;
    }

    public function delete($id)
    {
        $employe = Employe::findOrFail($id);
        $employe->immeubles()->detach();
        $employe->delete();

        session()->flash('success', 'Employé supprimé avec succès.');
    }
}
