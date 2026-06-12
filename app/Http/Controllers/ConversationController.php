<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ConversationController extends Controller
{
    public function show($id){
        $conversation = Conversation::findOrFail($id);
        $messagesConv = $conversation->messages()->get();
        return view('conversations.show',compact('conversation','messagesConv'));
    }

    public function store($commande_id,$artiste_id){

        $conversation = Conversation::firstOrCreate(
            ['commande_id' => $commande_id],
            ['client_id' => Auth::id(), 'artiste_id' => $artiste_id ]
        );
        return redirect(route('conversations.show',$conversation->id));
    }
    
}
