<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notation extends Model
{
    use HasFactory;

    protected $primaryKey = ['user_id', 'monster_id']; // Définition des clés primaires
    public $incrementing = false; // Désactive l'auto-incrémentation

    protected $fillable = ['user_id', 'monster_id', 'notation'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function monster()
    {
        return $this->belongsTo(Monster::class);
    }
}
