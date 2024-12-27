<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Role;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Show edit form for a specific task
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    // Update task
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'task_name' => 'required|string|max:255',
            'task_details' => 'nullable|string',
        ]);

        $task->update($validated);

        // Redirect to the dashboard with a success message
        return redirect()->route('dashboard')->with('success', 'Task updated successfully!');
    }

    // Show task details with roles
    public function show(Task $task)
    {
        // Fetch all available roles to display in the dropdown
        $roles = Role::all();

        return view('tasks.show', compact('task', 'roles'));
    }

    // Delete task
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('dashboard')->with('success', 'Task deleted successfully!');
    }

    // Assign roles to a task
    public function assignRoles(Request $request, Task $task)
    {
        $validated = $request->validate([
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);

        // Sync roles with the task (adds or removes roles as necessary)
        $task->roles()->sync($validated['roles']);

        return redirect()->route('tasks.show', $task->id)->with('success', 'Roles assigned successfully!');
    }
}
