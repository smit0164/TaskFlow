<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class UsersDashboardController extends Controller
{
    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $intern = Auth::guard('intern')->user();

        // Fetch tasks assigned to the logged-in intern with the admin who created them
        $tasks = $intern->tasks()->with('createdBy')->latest()->get();  // Use 'createdBy' instead of 'admin'
        
        return view('users.dashboard', compact('tasks'));
    }
    
}
