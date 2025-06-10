<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    protected $table = 'historiques'; // ou le nom de ta table
    protected $fillable = ['id_A', 'mois', 'annee', 'montant_paye', 'recu'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
