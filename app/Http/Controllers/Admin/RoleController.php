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
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        try {
            if ($request->has('permissions')) {
                $request->validate([
                    'permissions' => 'required|array',
                ]);
            }else{
                $request->validate([
                    'is_super' => 'required',
                ]);
            }
            $request->validate([
                'name' => 'required|string|max:255|unique:roles',
            ]);
            $role = Role::create([
                'name' => $request->name,
                'is_super' => $request->has('is_super'),
            ]);
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
            $role = Role::findOrFail($role);
            if ($role->is_super == 1) {
                return redirect()->route('admin.roles.index')->with('error', 'The Super Admin role cannot be edited.');
            }

            $permissions = Permission::all();
            return view('admin.roles.edit', compact('role', 'permissions'));
            
        } catch (\Exception $e) {
            return redirect()->route('admin.roles.index')->with('error', 'Role not found or error occurred: ' . $e->getMessage());
        }
    }

     public function update(Request $request, $role)
    {
        try {
            $role = Role::findOrFail($role);

            // Prevent update if it's a Super Admin role
            if ($role->is_super == 1) {
                return redirect()->route('admin.roles.index')->with('error', 'The Super Admin role cannot be updated.');
            }

            // Validate the form data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'permissions' => 'sometimes|array',
                'permissions.*' => 'exists:permissions,id',
            ]);

            // Update the role name
            $role->name = $validated['name'];

            // Check if marked as super admin
            if ($request->has('is_super') && $request->is_super) {
                $role->permissions()->detach();
                $role->is_super = true;
            } else {
                if (isset($validated['permissions'])) {
                    $role->permissions()->sync($validated['permissions']);
                } else {
                    $role->permissions()->sync([]); // Optional: clear permissions if none selected
                }
                $role->is_super = false;
            }

            $role->save();

            return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
            
        } catch (\Exception $e) {
            return redirect()->route('admin.roles.index')->with('error', 'Error updating role: ' . $e->getMessage());
        }
    }

    

    public function destroy($role)
    {
        try {
            // Find the role to delete
            $role = Role::findOrFail($role);

            // Check if the role is Super Admin
            if ($role->is_super == 1) {
                return redirect()->route('admin.roles.index')->with('error', 'The Super Admin role cannot be updated.');
            }
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
