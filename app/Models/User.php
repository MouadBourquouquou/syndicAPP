<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Si ta clé primaire ne s'appelle pas "id", il faut la spécifier :
    protected $primaryKey = 'id';

    // Si ta table ne s'appelle pas "users", spécifie son nom :
    protected $table = 'users'; // Change ceci si ta table porte un autre nom

    // Champs que l'on peut remplir avec create() ou update()
    protected $fillable = [
        'name',
        'prenom',
        'statut',
        'nom_societé',
        'adresse',
        'tel',
        'Fax', // <-- Il est déjà là !
        'ville',
        'email',
        'password',
        'is_admin' => 0,
        'is_active' => 0,
    ];

    // Champs masqués quand on fait un retour JSON ou array
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casts pour certains champs
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    public function isSyndic()
    {
        return $this->statut === 'syndic';
    }

    public function isEmploye()
    {
        return $this->statut === 'employe';
    }
    // Si la clé primaire n'est pas auto-incrémentée (au cas où), décommenter :
    // public $incrementing = false;
}