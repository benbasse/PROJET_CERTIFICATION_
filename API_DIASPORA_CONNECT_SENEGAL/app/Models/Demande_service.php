<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande_service extends Model
{
    use HasFactory;

    public function User()
    {
        return $this->belongsToMany(User::class, 'users_id');
    }

    public function Service()
    {
        return $this->belongsToMany(Service::class, 'services_id');
    }
}
