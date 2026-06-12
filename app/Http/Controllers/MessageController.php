<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function store(Request $request,$conversation){
        Message::create([ 
            'contenu' => $request->message,
            'emetteur_id' => Auth::id(),   
            'conversation_id' => $conversation],
        );
    }

}
