<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Intern;
use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    public function index()
    {
        // Fetch all interns for the admina to select from
        $interns = Intern::latest()->get();
        
        // Return the view with the intern list
        
        return view('admin.messages.index', compact('interns'));
    }

    public function openChat($id)
    {
        // Fetch the intern's data from the database
        $intern = Intern::findOrFail($id);

        // Optionally, fetch any chat messages between the admin and the intern
        // (you might need a Message model for this)
        $messages = Message::where('intern_id', $id)
                           ->orWhere('admin_id', auth()->guard('admin')->id())
                           ->get();

        // Return the chat view and pass necessary data
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
    
        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }
   
    public function fetch($intern_id)
    {
        $admin_id = auth()->guard('admin')->id();
        
        // Fetch the messages where the intern_id and admin_id match
        $messages = Message::where('intern_id', $intern_id)
                            ->where('admin_id', $admin_id)  // Make sure admin_id matches the authenticated admin
                            ->orderBy('created_at', 'asc')
                            ->get();
        
        return response()->json($messages);
    }
    


}
