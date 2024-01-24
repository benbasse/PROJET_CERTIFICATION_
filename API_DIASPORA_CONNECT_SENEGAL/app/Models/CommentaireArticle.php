<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentaireArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        "users_id",
        "articles_id",
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
