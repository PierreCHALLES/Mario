<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    // Si ta table a un autre nom que "films", spécifie-le ici
    // protected $table = 'nom_de_la_table';

    // Si nécessaire, spécifie les champs de la table Film qui sont modifiables
    protected $fillable = [
        'title',
        'description',
        'genre',
        'epoque',
        'lastUpdate',
    ];
}
