<?php

namespace App\Http\Controllers;

use App\GroupChat;
use Illuminate\Http\Request;

class GroupChatController extends Controller
{
    public function index()
    {
        $messages = GroupChat::with('user')->get();

        return $messages;
    }

    public function store(Request $request)
    {
        return GroupChat::create([
            'sender_id' => $request->get('sender_id'),
            'message'   => $request->get('message'),
        ]);
    }
}
