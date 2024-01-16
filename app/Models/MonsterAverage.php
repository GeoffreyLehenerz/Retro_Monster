<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonsterAverage extends Model
{
    use HasFactory;

    protected $table = 'v_monster_average';
    protected $primaryKey = 'monster_id'; // Définir la clé primaire pour la jointure
    public $incrementing = false;         // Important car monster_id n'est pas auto-increment
    public $timestamps = false;           // Pas de timestamps dans cette vue

}
