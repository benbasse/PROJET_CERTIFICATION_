<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maison extends Model
{
    use HasFactory;

    public function User()
    {
        return $this->hasMany(User::class);
    }

    public function Commentaire()
    {
        return $this->hasMany(Commentaire::class);
    }
}
