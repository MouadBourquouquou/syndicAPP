<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employe extends Model
{
    use HasFactory;

    protected $table = 'employes';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'ville',
        'adresse',
        'poste',
        'immeuble_id',
        'residence_id',
        'date_embauche',
        'salaire',
    ];

    protected $casts = [
        'date_embauche' => 'date',
        'salaire' => 'decimal:2',
    ];

    // Relation vers Immeuble
    public function immeuble()
{
    return $this->belongsTo(Immeuble::class, 'immeuble_id');
}
// Relation vers residence
public function residence()
{
    return $this->belongsTo(Residence::class, 'residence_id');
}

    protected $primaryKey = 'id_E';
public $incrementing = true;
protected $keyType = 'int';

}
