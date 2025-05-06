<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        Message::create([
            'admin_id' => $request->admin_id,
            'intern_id' => $request->intern_id,
            'sender_type' => $request->sender_type,
            'message' => $request->message,
        ]);

        return response()->json(['status' => 'Message sent']);
    }

    public function fetch(Request $request)
    {
        $messages = Message::where('admin_id', $request->admin_id)
            ->where('intern_id', $request->intern_id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }
}
