<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    
    protected $fillable = [
        'commentaire',
        'user_id',     
        'commentaire_id',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentaire()
    {
        return $this->belongsTo(Commentaire::class);
    }
}
