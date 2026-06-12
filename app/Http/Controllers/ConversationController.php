<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ConversationController extends Controller
{
    public function show(Conversation $conversation){
        $conversation->messages()->where('emetteur_id', Auth::id())->whereNull('lu_a')->update('lu_a');
        $messages = $conversation->messages()->get();
        return view('conversations.show',compact('conversation','messages'));
    }

    

    public function store($commande_id,$artiste_id){

        $conversation = Conversation::firstOrCreate(
            ['commande_id' => $commande_id],
            ['client_id' => Auth::id(), 'artiste_id' => $artiste_id ]
        );
        return redirect(route('conversations.show',$conversation->id));
    }

    public function index()
    {
        $conversations = Conversation::where('client_id', Auth::id())
            ->orWhere('artiste_id', Auth::id())
            ->with(['messages' => fn($q) => $q->latest()->limit(1)])
            ->latest()
            ->get();

        return view('compte.conversations.index', compact('conversations'));
    }
    
    
}
