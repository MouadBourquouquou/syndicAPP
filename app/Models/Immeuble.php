<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Immeuble extends Model
{
    protected $table = 'immeuble'; // Nom personnalisé de la table (si ce n’est pas "immeubles")

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
     * Un immeuble a plusieurs employés.
     */
    public function employes()
    {
        return $this->hasMany(Employe::class, 'immeuble_id');
    }

    /**
     * Un immeuble a plusieurs appartements.
     */
    public function appartements()
    {
        return $this->hasMany(Appartement::class, 'immeuble_id');
    }

    /**
     * Un immeuble appartient à une résidence.
     */
    public function residence()
    {
        return $this->belongsTo(Residence::class, 'residence_id');
    }
}
