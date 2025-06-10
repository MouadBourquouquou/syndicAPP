<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appartement extends Model
{
    use HasFactory;

    protected $table = 'appartements';

    // Définir la clé primaire personnalisée
    protected $primaryKey = 'id_A';
    public $incrementing = true;
    protected $keyType = 'int';

    // Champs remplissables en masse
    protected $fillable = [
        'CIN_A',
        'Nom',
        'Prenom',
        'immeuble_id',
        'numero',
        'surface',
        'montant_cotisation_mensuelle',
        'dernier_mois_paye',
        'telephone',
        'email',
    ];

    // Cast pour gérer automatiquement le format date
    protected $casts = [
        'dernier_mois_paye' => 'date:Y-m',
    ];

    // Relation vers l'immeuble
   public function immeuble()
{
    return $this->belongsTo(Immeuble::class, 'immeuble_id', 'id');
}

}
