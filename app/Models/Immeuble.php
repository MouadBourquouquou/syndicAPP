<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Immeuble extends Model
{
    protected $table = 'immeuble';

    protected $fillable = [
        'nom',
        'ville',
        'code_postal',
        'adresse',
        'nombre_app',
        'cotisation',
        'caisse',
        'residence_id',
    ];

    /**
     * Relation plusieurs-à-plusieurs avec Employe
     */
    public function employes()
    {
        return $this->belongsToMany(Employe::class, 'employe_immeuble', 'immeuble_id', 'employe_id');
    }

    /**
     * Relation un-à-plusieurs avec Appartement
     */
    public function appartements()
    {
        return $this->hasMany(Appartement::class);
    }

    /**
     * Relation plusieurs immeubles pour une résidence
     */
    public function residence()
    {
        return $this->belongsTo(Residence::class, 'id_residence');
    }
    
}
