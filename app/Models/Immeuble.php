<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Immeuble extends Model
{
    protected $table = 'immeuble'; // si ce n'est pas par défaut

    protected $fillable = [
        'nom', 'ville', 'code_postal', 'adresse', 'nombre_app',
        'cotisation', 'caisse', 'residence_id',
    ];

    /**
     * Relation : Un immeuble a plusieurs appartements.
     */
    public function employes()
    {
        return $this->belongsToMany(Employe::class, 'employe_immeuble', 'immeuble_id', 'employe_id');
    }

    public function appartements()
    {
        return $this->hasMany(Appartement::class);
    }

    /**
     * Relation vers la résidence si applicable
     */
    public function residence()
    {
        return $this->belongsTo(Residence::class);
    }
    
}
