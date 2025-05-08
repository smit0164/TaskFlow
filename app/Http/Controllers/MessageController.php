<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Intern;
use App\Jobs\SendMessage;
use App\Models\Admin;

class MessageController extends Controller
{
    public function index()
    {
        // Fetch all interns for the admina to select from
        $interns = Intern::latest()->get();
        
        // Return the view with the intern list
        
        return view('admin.messages.index', compact('interns'));
    }
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
    public function openChatAdminIntern($id)
    {
        // Fetch the intern's data from the database
        $intern = Intern::findOrFail($id);
        $messages = Message::where('intern_id', $id)
                           ->orWhere('admin_id', auth()->guard('admin')->id())
                           ->get();

        return view('admin.messages.chat', compact('intern', 'messages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'admin_id' => 'required|exists:admins,id',
            'intern_id' => 'required|exists:interns,id',
            'sender_type' => 'required|in:admin,intern',
        ]);

        $message = Message::create($validated);

        // Dispatch job for real-time broadcast
        SendMessage::dispatch($message);

        return response()->json([
            'success' => true,
            'message' => 'Message created and job ',
            'data' => $message, // Optional: return stored message
        ]);
    }

    public function fetchMessages(Request $request)
    {
        try {
            $data = $request->validate([
                'admin_id' => 'required|integer',
                'intern_id' => 'required|integer',
            ]);

            $messages = Message::where(function ($query) use ($data) {
                $query->where('admin_id', $data['admin_id'])
                      ->where('intern_id', $data['intern_id']);
            })->orWhere(function ($query) use ($data) {
                $query->where('admin_id', $data['admin_id'])
                      ->where('intern_id', $data['intern_id']);
            })->orderBy('created_at', 'asc')->get();

            return response()->json([
                'success' => true,
                'messages' => $messages
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching messages: ' . $e->getMessage()
            ], 500);
        }
    }
}
