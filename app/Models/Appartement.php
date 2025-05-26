<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appartement extends Model
{
    use HasFactory;

    protected $fillable = [
        'immeuble_id',
        'numero',
        'surface',
        'dernier_mois_paye',
        'telephone',
    ];

    protected $dates = ['dernier_mois_paye'];
}
