<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Commentaire extends Model
{
   
    //
    protected $fillable = ['url', 'titre', 'commentaire', 'user_id'];

    // relation pour plusieurs commentaires à un poste
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
         return $this->belongsTo(User::class);
    }
}
