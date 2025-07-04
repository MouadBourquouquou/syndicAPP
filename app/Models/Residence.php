<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Residence extends Model
{
    protected $fillable = [
        'nom',
        'nombre_immeubles',
        'ville',
        'code_postal',
        'adresse',
        'cotisation',
        'caisse',
        'id_S'
    ];
    public function immeubles()
{
    return $this->hasMany(Immeuble::class);
}
    public function employes()
    {
        return $this->hasMany(Employe::class);
    }
    
}
