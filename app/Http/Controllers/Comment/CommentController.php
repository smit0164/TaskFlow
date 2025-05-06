<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
class CommentController extends Controller
{
    public function store(Request $request)
    {
       
        $request->validate([
            'task_id'     => 'required|exists:tasks,id',
            'description' => 'required|string',
            'user_type'   => 'required|in:admin,intern',
        ]);
        
        $user = null;
        $commenterType = null;
    
        if ($request->user_type === 'admin') {
            $user = Auth::guard('admin')->user();
            $commenterType = \App\Models\Admin::class;
        } else {
            $user = Auth::guard('intern')->user();
            $commenterType = \App\Models\Intern::class;
        }
      
        if (!$user) {
            abort(403, 'Unauthorized user.');
        }
    
        Comment::create([
            'task_id'        => $request->task_id,
            'description'    => $request->description,
            'commenter_id'   => $user->id,
            'commenter_type' => $commenterType,
            'user_type'      => $request->user_type,
        ]);
    
        return redirect()->back()->with('success', 'Comment posted successfully!');
    }
    
}
