<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonsterType extends Model
{
    use HasFactory;

    public function monsters()
    {
        return $this->hasMany(Monster::class, 'type_id');
    }
}
