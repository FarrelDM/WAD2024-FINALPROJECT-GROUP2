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
        $notifications = Notification::with('task')->get(); // Include associated tasks
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

        $task = $request->task_id ? Task::find($request->task_id) : null;

        $notification = Notification::create([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'roles' => $validated['roles'] ?? [],
            'task_id' => $validated['task_id'],
            'reminder_time' => $task ? $task->date : now(), // Use task's date if available
        ]);

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

        $task = $request->task_id ? Task::find($request->task_id) : null;

        $notification->update([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'roles' => $validated['roles'] ?? [],
            'task_id' => $validated['task_id'],
            'reminder_time' => $task ? $task->date : now(), // Update reminder time if task changes
        ]);

        return redirect()->route('dashboard')->with('success', 'Notification updated successfully');
    }
    public function destroy(Notification $notification)
{
    $notification->delete();

    return redirect()->route('dashboard')->with('success', 'Notification deleted successfully.');
}


}
