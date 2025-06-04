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
        'montant',
        'mois_paye',
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
        return $this->belongsTo(Syndic::class, 'id_S');
    }
}
