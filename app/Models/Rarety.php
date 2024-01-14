<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rarety extends Model
{
    use HasFactory;

    public function monsters()
    {
        return $this->hasMany(Monster::class, 'rarety_id');
    }
}
