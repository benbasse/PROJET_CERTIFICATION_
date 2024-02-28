<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terrain extends Model
{
    use HasFactory;
    protected $fillable = [
        'est_acheter',
        
    ];
    public function User()
    {
        return $this->hasMany(User::class);
    }
}
