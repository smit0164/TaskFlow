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
        // Get currently logged-in admin using guard
        $admin = Auth::guard('admin')->user();

        // Get tasks created by this admin
        $tasks = Task::where('created_by', $admin->id)->with('interns')->latest()->get();

        // Get all interns
        $interns = Intern::latest()->get();

        return view('admin.dashboard', compact('tasks', 'interns'));
    }
}
