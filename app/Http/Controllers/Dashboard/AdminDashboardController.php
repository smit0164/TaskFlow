<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ This line is necessary
use App\Models\Task;
use App\Models\Intern;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();

        // Check if the admin has 'super-admin' permission
        if ($admin->isSuperAdmin()) {
            // If the admin is super-admin, fetch all tasks
            $tasks = Task::with('interns')->latest()->get();
        } else {
            // If the admin is not super-admin, fetch only tasks created by this admin
            $tasks = Task::where('created_by', $admin->id)->with('interns')->latest()->get();
        }
    

        $interns = Intern::latest()->get();

        return view('admin.dashboard', compact('tasks', 'interns'));
    }
}
