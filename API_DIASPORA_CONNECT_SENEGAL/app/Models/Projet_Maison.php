<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet_Maison extends Model
{
    use HasFactory;

    public function User()
    {
        return $this->belongsToMany(User::class);
    }

    public function Maison()
    {
        return $this->belongsTo(Maison::class);
    }
}
