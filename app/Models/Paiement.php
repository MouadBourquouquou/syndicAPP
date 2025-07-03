<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $table = 'paiement';

    protected $fillable = [
        'id_A',
        'id_E',
        'id_S',
        'mois_payes',  // Ajout de la colonne JSON ici
    ];

    protected $casts = [
        'mois_payes' => 'array',  // Pour que laravel convertisse JSON <=> array automatiquement
    ];


    public function appartement()
    {
        return $this->belongsTo(Appartement::class, 'id_A');
    }

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'id_E');
    }

    public function syndic()
    {
        return $this->belongsTo(user::class, 'id_S');
    }
}
