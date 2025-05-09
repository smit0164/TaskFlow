<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Role;

class ManageUserController extends Controller
{
    public function index()
    {
        $users = Admin::with('role')->get();
        return view('admin.users.index', compact('users'));
    }

    // Show create form
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    // Store a new user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);
    
        try {
            $user = new Admin();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->password = bcrypt($validated['password']);
            $user->role_id = $validated['role_id'];
            $user->save();
    
            return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }
    

    // Show edit form
    public function edit($id)
    {
        $user = Admin::findOrFail($id);
        $roles = Role::all();
       
        return view('admin.users.edit', compact('user', 'roles'));
    }

    // Update user
    public function update(Request $request, $id)
    {
          // Validate the request data
          $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:admins,email,{$id}",
            'password' => 'nullable|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
          ]);
        try {
            // Find the user by ID, or fail if not found
            $user = Admin::findOrFail($id);
          // Update the user attributes
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->role_id = $validated['role_id'];
    
            // Update the password only if it's provided
            if (!empty($validated['password'])) {
                $user->password = bcrypt($validated['password']);
            }
    
            // Save the updated user to the database
            $user->save();
    
            // Redirect with success message
            return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    
        } catch (\Exception $e) {
            // Log the exception if needed
            \Log::error('Error updating user: ' . $e->getMessage());
    
            // Redirect back with an error message
            return back()->with('error', 'An error occurred while updating the user. Please try again later.');
        }
    }
    

    // Delete user
    public function destroy($id)
    {
        try {
            // Find the user or fail if not found
            $user = Admin::findOrFail($id);
    
            // Delete the user
            $user->delete();
    
            // Redirect with success message
            return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            // Log the error (optional)
            \Log::error("Error deleting user: " . $e->getMessage());
    
            // Redirect with error message
            return redirect()->route('admin.users.index')->with('error', 'Failed to delete user. Please try again later.');
        }
    }
    
}
