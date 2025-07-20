<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    protected $primaryKey = 'id_E';

    protected $fillable = [
        'nom', 'prenom', 'email', 'telephone', 'ville', 'adresse',
        'poste','date_embauche', 'salaire','id_S'
    ];

   public function immeubles()
    {
        return $this->belongsToMany(Immeuble::class, 'employe_immeuble', 'employe_id', 'immeuble_id');
    }

    public function getFirstResidenceName()
    {
        return $this->immeubles->first()?->residence->nom ?? 'Aucune résidence';
    }


}
