<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monster extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'rarety_id',
        'type_id',
        'pv',
        'attack',
        'defense',
        'image_url',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function monsterType()
    {
        return $this->belongsTo(MonsterType::class, 'type_id');
    }

    public function rarety()
    {
        return $this->belongsTo(Rarety::class, 'rarety_id');
    }

    public function monsterAverage()
    {
        return $this->hasOne(MonsterAverage::class, 'monster_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'monster_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'monster_id');
    }

    public function notations()
    {
        return $this->hasMany(Notation::class, 'monster_id');
    }
}
