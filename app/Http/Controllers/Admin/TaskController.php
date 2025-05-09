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
        try {
            $admin = Auth::guard('admin')->user();
            if ($admin->isSuperAdmin()) {
                $tasks = Task::with('interns')->latest()->get();
            } else {
                $tasks = Task::where('created_by', $admin->id)->with('interns')->latest()->get();
            }
            return view('admin.tasks.index', compact('tasks'));
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')->withErrors('Something went wrong while fetching tasks.');
        }
    }

    public function create()
    {
        $interns = Intern::all();
        return view('admin.tasks.create', compact('interns'));
    }
    
    public function store(TaskRequest $request)
    {
        try {
            $validated = $request->validated();
            $task = Task::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'created_by' => Auth::guard('admin')->user()->id, // Guard-based user ID
            ]);
            $task->interns()->attach($validated['assigned_to']);
            return redirect()->route('admin.tasks.index')->with('success', 'Task created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([
                'error' => 'Something went wrong while creating the task. Please try again.',
            ]);
        }
    }

    public function edit(Task $task)
    {
        $interns = Intern::all();
        return view('admin.tasks.edit', compact('task', 'interns'));
    }

    public function update(TaskRequest $request, Task $task)
    {
        try {
            $validated = $request->validated();
            $task->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
            ]);
            $task->interns()->sync($validated['assigned_to']);
            return redirect()->route('admin.tasks.index')->with('success', 'Task updated successfully.');
            
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([
                'error' => 'Something went wrong while updating the task. Please try again.',
            ]);
        }
    }

    public function destroy(Task $task)
    {
        try {
            
            $task->interns()->detach();
            $task->delete();
            return redirect()->route('admin.tasks.index')->with('success', 'Task deleted successfully.');
            
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'error' => 'Something went wrong while deleting the task. Please try again.',
            ]);
        }
    }
}
