<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Http\Requests\InternRequest;
use Illuminate\Support\Facades\DB;

use App\Models\Intern;

class InternController extends Controller
{
    public function index()
    {
        $interns = Intern::with('tasks')->get();
        return view('admin.intern.index', compact('interns'));
    }
    public function create()
    {
        return view('admin.intern.create');
    }

    public function store(InternRequest $request)
    {
        try {
            $adminId = Auth::guard('admin')->user()->id;
            $intern = Intern::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt('123456'),
            ]);
        
            if(isset($request->task_title[0])){
                 $tasks = [];
                foreach ($request->task_title as $index => $title) {
                    $task = Task::create([
                        'title' => $title,
                        'description' => $request->task_description[$index] ?? null,
                        'created_by' => $adminId,
                    ]);
        
                    $tasks[] = [
                        'intern_id' => $intern->id,
                        'task_id' => $task->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
           
    
            if (!empty($tasks)) {
                DB::table('intern_task')->insert($tasks);
            } else {
                \Log::warning('No tasks were added for intern ID: ' . $intern->id);
            }
    
            return redirect()->route('admin.interns.index')->with('success', 'Intern and tasks added successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to store intern: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong while creating the intern.');
        }
    }
    public function edit($id)
    {
        $intern = Intern::with('tasks')->findOrFail($id); 
        return view('admin.intern.edit', compact('intern')); // Pass intern to the view
    }
    
    public function update(InternRequest $request, $id)
    {
        try {
            $intern = Intern::findOrFail($id);
            $intern->name = $request->name;
            $intern->email = $request->email;
            if ($request->filled('password')) {
                $intern->password = bcrypt($request->password);
            }
            $intern->save();
            return redirect()->route('admin.interns.index')->with('success', 'Intern updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong while updating the intern.');
        }
    }
    
    public function destroy($id)
    {
        try {
            $intern = Intern::findOrFail($id);
            $intern->tasks()->detach();
            $intern->delete();
             return redirect()->route('admin.interns.index')->with('success', 'Intern deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong while deleting the intern.');
        }
    }
    


}
