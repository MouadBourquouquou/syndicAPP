<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Charge extends Model
{
    use HasFactory;

    protected $table = 'charges';

    protected $fillable = [
        'immeuble_id',
        'id_residence',
        'type',
        'description',
        'montant',
        'date',
        'etat',
    ];

    protected $casts = [
        'date' => 'date',
        'montant' => 'decimal:2',
    ];

    // Relation vers Immeuble
    public function immeuble()
    {
        return $this->belongsTo(Immeuble::class, 'immeuble_id');
    }

    // Relation vers Residence
    public function residence()
    {
        return $this->belongsTo(Residence::class, 'id_residence');
    }
}