<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function chatForm($user_id){
        $receiver=User::findOrfail($user_id);
        return \view('Dashboard.User.chat',\compact('receiver'));
    }

    public function sendMessage(Request $r,$user_id){

        $message = Message::create([
            'sender' => Auth::user()->id, // Get currently logged-in user ID
            'receiver' => $user_id, // Get currently logged-in user ID
            'message' => $r->message,
        ]);

        $receiver=User::findOrfail($user_id);

        \broadcast(new MessageSent($receiver,$r->message));

        return \response()->json('message sent');
    }
}
