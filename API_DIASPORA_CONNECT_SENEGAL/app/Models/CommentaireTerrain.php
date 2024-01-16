<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentaireTerrain extends Model
{
    use HasFactory;

    protected $fillable = [
        "contenue",
        "users_id",
        "terrains_id",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function terrain()
    {
        return $this->belongsTo(User::class);
    }
}
