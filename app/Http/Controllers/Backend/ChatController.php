<?php

namespace App\Http\Controllers\Backend;


use Carbon\Carbon;
use App\Models\User;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function SentMessage(Request $request){
        $request->validate([
            'msg' => 'required'
        ]);

        ChatMessage::create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => $request->receiver_id,
            'msg' => $request->msg,
            'created_at' => Carbon::now(),
        ]);
        return response()->json(['message' => 'Message Send Successfully']);

    }//end function

    public function LiveChat(){
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('frontend.dashboard.livechat', compact('profileData'));

    }//end function
    public function GetAllUser(){
    $chats = ChatMessage::orderBy('id','DESC')
    ->where('sender_id', Auth::user()->id)
    ->orWhere('receiver_id', Auth::user()->id)
    ->get();

    $users = $chats->flatMap(function($chat){
        if($chat->sender_id === auth()->id()) {
            return [$chat->sender, $chat->receiver];
        }
        return  [$chat->receiver, $chat->sender];

    })->unique();
    return $users;
    }//end function

    public function UserMessageById($id){
      $user = User::find($id);
      if($user){
        $messages = ChatMessage::where(function($q) use ($id)  {
             $q->where('sender_id', auth()->id());
             $q->where('receiver_id', $id);
        })->orWhere(function($q) use ($id){
            $q->where('sender_id',$id);
            $q->where('receiver_id', auth()->id());
        })->with('user')->get();

        return response()->json([
            'user' => $user,'messages' => $messages
        ]);
      } else {
         abort(404);
      }
    }//end function
}

