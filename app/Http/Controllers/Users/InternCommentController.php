<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class InternCommentController extends Controller
{
    public function store(Request $request)
    {
      
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'content' => 'required|string|max:1000',
        ]);
    
        // Check authentication via guards
        $user = null;
        $type = null;
    
        if (auth('admin')->check()) {
            $user = auth('admin')->user();
            $type = Admin::class;
        } elseif (auth('intern')->check()) {
            $user = auth('intern')->user();
            $type = Intern::class;
        }
    
        // If user is not authenticated
        if (!$user || !$type) {
            return redirect()->back()->withErrors(['error' => 'Unauthorized user.']);
        }
    
        // Store the comment
        \App\Models\Comment::create([
            'task_id' => $request->task_id,
            'user_id' => $user->id,
            'type'    => $type,
            'content' => $request->content,
        ]);
    
        return redirect()->back()->with('success', 'Comment added successfully.');
    }
    
public function showComments($taskId)
{
    // Fetch comments for a specific task
    $comments = Comment::where('task_id', $taskId)
                       ->with('commentable') // Fetch the comment's author (Admin/Intern)
                       ->latest()
                       ->get();

    return response()->json($comments); // Return comments as JSON
}
}
