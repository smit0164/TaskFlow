<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message; // Assuming you have a Message model for storing messages.
use App\Models\Admin;

class MessageController extends Controller
{
    public function show($admin_id)
    {
        // Fetch the admin details
        $admin = Admin::findOrFail($admin_id);
    
        $intern_id = auth('intern')->id(); // Use the correct guard
    
        // Fetch messages where this specific intern and admin are chatting
        $messages = Message::where('admin_id', $admin_id)
                            ->where('intern_id', $intern_id)
                            ->orderBy('created_at', 'asc')
                            ->get();
    
        // Pass the admin and messages to the view
        return view('users.messages.chat', compact('messages', 'admin_id', 'admin'));
    }
    
    
    

    public function store(Request $request)
    {
        // Validate the incoming message request
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'admin_id' => 'required|exists:admins,id',
            'intern_id' => 'required|exists:interns,id',
            'sender_type' => 'required|in:intern', // Ensure the sender is the intern
        ]);

        // Store the new message in the database
        $message = Message::create([
            'message' => $validated['message'],
            'admin_id' => $validated['admin_id'],
            'intern_id' => $validated['intern_id'],
            'sender_type' => $validated['sender_type'],
        ]);
    
        // Return a success response with the stored message
        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }
    public function fetch($admin_id)
    {
        $intern_id =  auth()->guard('intern')->id();; // Get the currently logged-in intern/user ID
    
        // Fetch messages exchanged between this intern and the given admin
        $messages = Message::where('admin_id', $admin_id)
                           ->where('intern_id', $intern_id)
                           ->orderBy('created_at', 'asc')
                           ->get();
    
        return response()->json($messages);
    }
    
    
}
