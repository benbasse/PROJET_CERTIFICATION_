<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre', 
        'image', 
        'description'
    ];

    public function User()
    {
        return $this->hasMany(User::class);
    }
}
