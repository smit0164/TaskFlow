<?php

// app/Http/Controllers/Admin/RoleController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        // Fetch all roles with their associated permissions
        $roles = Role::with('permissions')->get();

        // Return the index view with roles
        return view('admin.roles.index', compact('roles'));
    }
    public function create()
    {
        // Fetch all permissions to display in the UI
        $permissions = Permission::all();
        
        // Return the view with permissions
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        try {
            
            $request->validate([
                'name' => 'required|string|max:255|unique:roles',
            ]);
    
            // Create the role
            $role = Role::create([
                'name' => $request->name,
                'is_super' => $request->has('is_super'),
            ]);
            
            // Only attach permissions if not super admin
            if (!$role->is_super && $request->has('permissions')) {
                $role->permissions()->attach($request->permissions);
            }
    
            return redirect()->route('admin.roles.index')->with('success', 'Role created successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to create role: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong while creating the role.');
        }
    }
    
    public function edit($role)
    {
        try {
            // Attempt to find the role by its ID
            $role = Role::findOrFail($role);
            
            // Fetch all permissions
            $permissions = Permission::all();
            
            // Return the edit view with the role and permissions
            return view('admin.roles.edit', compact('role', 'permissions'));
            
        } catch (\Exception $e) {
            // Handle the exception if the role is not found or any other error occurs
            return redirect()->route('admin.roles.index')->with('error', 'Role not found or error occurred: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $role)
    {
        try {
            // Validate the form data
           
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'permissions' => 'array',
                'permissions.*' => 'exists:permissions,id', // Ensure the permissions exist in the database
            ]);
    
            // Find the role to update
            $role = Role::findOrFail($role);
    
            // If the Super Admin role is selected
            if ($request->has('is_super') && $request->is_super) {
                // Detach old permissions and only update the role table to mark it as Super Admin
                $role->permissions()->detach(); // Detach all old permissions
                $role->is_super = true; // Mark the role as Super Admin
            } else {
                // Otherwise, update permissions based on the selected ones
                $role->permissions()->sync($validated['permissions']);
                $role->is_super = false; // Ensure that the role is not Super Admin
            }
    
            // Update the role name
            $role->name = $validated['name'];
            $role->save();
    
            // Redirect with success message
            return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
            
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the update
            return redirect()->route('admin.roles.index')->with('error', 'Error updating role: ' . $e->getMessage());
        }
    }
    
    

    public function destroy($role)
    {
        try {
            // Find the role to delete
            $role = Role::findOrFail($role);
    
            // Detach permissions associated with the role (if any)
            $role->permissions()->detach();
    
            // Delete the role
            $role->delete();
    
            // Redirect with success message
            return redirect()->route('admin.roles.index')->with('success', 'Role and associated permissions deleted successfully.');
            
        } catch (\Exception $e) {
            // Handle the exception
            return redirect()->route('admin.roles.index')->with('error', 'Error deleting role: ' . $e->getMessage());
        }
    }
    


}
