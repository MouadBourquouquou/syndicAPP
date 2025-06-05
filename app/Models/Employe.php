<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employe extends Model
{
    protected $primaryKey = 'id_E'; // clé primaire personnalisée

    protected $fillable = [
        'nom', 'prenom', 'email', 'telephone', 'ville', 'adresse', 
        'poste', 'residence_id', 'date_embauche', 'salaire'
    ];
public function immeuble()
{
    return $this->belongsTo(Immeuble::class);
}
    // Relation many-to-many avec immeubles via la table pivot "employe_immeuble"
    public function immeubles()
    {
        return $this->belongsToMany(Immeuble::class, 'employe_immeuble', 'employe_id', 'immeuble_id');
    }

    // Relation many-to-one avec residence
    public function residence()
    {
        return $this->belongsTo(Residence::class);
    }
    
}
