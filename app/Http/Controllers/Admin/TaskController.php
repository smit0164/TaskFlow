<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Intern;
use App\Models\Task;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
    
        // Check if the admin has 'super-admin' permission
        if ($admin->isSuperAdmin()) {
            // If the admin is super-admin, fetch all tasks
            $tasks = Task::with('interns')->latest()->get();
        } else {
            // If not super-admin, fetch only tasks created by this admin
            $tasks = Task::where('created_by', $admin->id)->with('interns')->latest()->get();
        }
    
        return view('admin.tasks.index', compact('tasks'));
    }
    
    

    public function create()
    {
        // Fetch all interns (you might want to filter or paginate this)
        $interns = Intern::all();
    
        return view('admin.tasks.create', compact('interns'));
    }

    public function store(TaskRequest $request)
    {
        try {
            $validated = $request->validated();
    
            // Create the Task with created_by using 'admin' guard
            $task = Task::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'created_by' => auth('admin')->id(), // Guard-based user ID
            ]);
    
            // Attach assigned interns
            $task->interns()->attach($validated['assigned_to']);
    
            return redirect()->route('admin.tasks.index')->with('success', 'Task created successfully.');
            
        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error('Task creation failed: ' . $e->getMessage());
    
            return redirect()->back()->withInput()->withErrors([
                'error' => 'Something went wrong while creating the task. Please try again.',
            ]);
        }
    }

    public function edit(Task $task)
    {
        // Fetch all interns (you might want to filter or paginate this)
        $interns = Intern::all();
       
        return view('admin.tasks.edit', compact('task', 'interns'));
    }

    public function update(TaskRequest $request, Task $task)
    {
        try {
            $validated = $request->validated();
    
            // Update the Task
            $task->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
            ]);
    
            // Sync the assigned interns (this will replace old assignments)
            $task->interns()->sync($validated['assigned_to']);
            
            return redirect()->route('admin.tasks.index')->with('success', 'Task updated successfully.');
            
        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error('Task update failed: ' . $e->getMessage());
    
            return redirect()->back()->withInput()->withErrors([
                'error' => 'Something went wrong while updating the task. Please try again.',
            ]);
        }
    }

    public function destroy(Task $task)
    {
        try {
            
            $task->interns()->detach();
    
            // Delete the task
            $task->delete();
    
            return redirect()->route('admin.tasks.index')->with('success', 'Task deleted successfully.');
            
        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error('Task deletion failed: ' . $e->getMessage());
    
            return redirect()->back()->withErrors([
                'error' => 'Something went wrong while deleting the task. Please try again.',
            ]);
        }
    }
}
