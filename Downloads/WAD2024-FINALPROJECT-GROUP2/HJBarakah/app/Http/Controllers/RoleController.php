<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * List all roles with their assigned users.
     */
    public function index()
    {
        // Retrieve all roles with their associated users
        $roles = Role::with('users')->get();

        // Pass the roles to the view
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created role in the database.
     */
    public function store(Request $request)
    {
        // Validate the role name
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        // Create the new role
        Role::create([
            'name' => $request->name,
        ]);

        // Redirect to roles index page with success message
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * Show the form to assign users to a role.
     */
    public function assignForm($roleId)
    {
        // Retrieve the role by ID
        $role = Role::findOrFail($roleId);

        // Get all users
        $users = User::all();

        // Pass the role and users to the view
        return view('roles.assign', compact('role', 'users'));
    }

    /**
     * Handle the form submission for assigning users to a role.
     */
    public function assignUser(Request $request, $roleId)
    {
        // Validate the incoming request
        $request->validate([
            'role_id' => 'required|exists:roles,id', // Ensure role exists
            'user_ids' => 'required|array', // Ensure users are selected
            'user_ids.*' => 'exists:users,id', // Ensure each user exists
        ]);

        // Find the role by ID
        $role = Role::findOrFail($roleId);

        // Attach the selected users to the role (many-to-many relationship)
        $role->users()->attach($request->user_ids); // Add users to the role

        // Redirect with a success message
        return redirect()->route('roles.index')->with('success', 'Users assigned to role successfully.');
    }

    /**
     * Remove a user from a role.
     */
    public function removeUser($roleId, $userId)
    {
        // Find the role and user by their IDs
        $role = Role::findOrFail($roleId);
        $user = User::findOrFail($userId);

        // Detach the user from the role
        $role->users()->detach($user->id);

        // Redirect back with success message
        return redirect()->route('roles.index')->with('success', 'User removed from role successfully.');
    }

    /**
     * Delete the specified role from the database.
     */
    public function destroy(Role $role)
    {
        // Delete the role
        $role->delete();

        // Redirect back with success message
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
