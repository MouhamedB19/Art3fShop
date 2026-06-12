<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'contenu',
        'emetteur_id',
        'conversation_id',
        'lu_a',
    ];

    public function emetteur(){
        return $this->belongsTo(User::class);
    }

    public function conversation(){
        return $this->belongsTo(Conversation::class);
    }
}
