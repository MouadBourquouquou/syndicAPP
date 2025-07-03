<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    protected $primaryKey = 'id_E';

    protected $fillable = [
        'nom', 'prenom', 'email', 'telephone', 'ville', 'adresse',
        'poste', 'immeuble_id', 'residence_id', 'date_embauche', 'salaire'
    ];

    // One immeuble per employé
    public function immeuble()
    {
        return $this->belongsTo(Immeuble::class, 'immeuble_id');
    }

    // One residence per employé
    public function residence()
    {
        return $this->belongsTo(Residence::class);
    }
}
