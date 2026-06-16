<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Conversation;

class MessageController extends Controller
{
    public function store(Request $request,Conversation $conversation){
        Message::create([ 
            'contenu' => $request->message,
            'emetteur_id' => Auth::id(),   
            'conversation_id' => $conversation->id],
        );
        return redirect()->route('conversations.show',$conversation);
    }

}
