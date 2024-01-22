<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier1 extends Model
{
    use HasFactory;

    private function User()
    {
        return $this->belongsToMany(User::class);
    }
    private function Maison()
    {
        return $this->belongsToMany(Maison::class);
    }


}
