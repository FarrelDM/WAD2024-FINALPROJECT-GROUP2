<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Task;
use App\Models\Role;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications.
     */
    public function index()
    {
        // Eager load roles and tasks for each notification
        $notifications = Notification::with(['roles', 'task'])->get();
        return response()->json($notifications);
    }

    /**
     * Show the form for creating a new notification.
     */
    public function create()
    {
        $roles = Role::all(); // Fetch all roles
        $tasks = Task::all(); // Fetch all tasks
        return view('notifications.create', compact('roles', 'tasks'));
    }

    /**
     * Store a newly created notification in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'roles' => 'nullable|array',
            'roles.*' => 'integer|exists:roles,id', // Ensure each role exists
            'task_id' => 'nullable|integer|exists:tasks,id', // Ensure task exists
        ]);

        // Create the notification
        $notification = Notification::create([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'task_id' => $validated['task_id'],
        ]);

        // Sync roles if provided
        if (!empty($validated['roles'])) {
            $notification->roles()->sync($validated['roles']);
        }

        return redirect()->route('dashboard')->with('success', 'Notification created successfully');
    }

    /**
     * Show the form for editing the specified notification.
     */
    public function edit(Notification $notification)
    {
        $roles = Role::all(); // Fetch all roles
        $tasks = Task::all(); // Fetch all tasks
        return view('notifications.edit', compact('notification', 'roles', 'tasks'));
    }

    /**
     * Update the specified notification in the database.
     */
    public function update(Request $request, Notification $notification)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'roles' => 'nullable|array',
            'roles.*' => 'integer|exists:roles,id',
            'task_id' => 'nullable|integer|exists:tasks,id',
        ]);

        // Update the notification
        $notification->update([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'task_id' => $validated['task_id'],
        ]);

        // Sync roles if provided
        if (!empty($validated['roles'])) {
            $notification->roles()->sync($validated['roles']);
        }

        return redirect()->route('dashboard')->with('success', 'Notification updated successfully');
    }

    /**
     * Remove the specified notification from the database.
     */
    public function destroy(Notification $notification)
    {
        $notification->roles()->detach(); // Detach roles
        $notification->delete(); // Delete the notification

        return redirect()->route('dashboard')->with('success', 'Notification deleted successfully.');
    }
}
