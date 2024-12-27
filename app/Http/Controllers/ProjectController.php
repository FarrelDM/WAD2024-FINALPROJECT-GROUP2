<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    // Show the list of all projects
    public function index()
    {
        $projects = Project::with('tasks')
            ->where('user_id', Auth::id())
            ->orWhereHas('members', function ($query) {
                $query->where('users.id', Auth::id()); // Explicitly specify the `users.id` column
            })
            ->get();
    
        return view('dashboard', compact('projects'));
    }
    

    // Show the form for creating a new project
    public function create()
    {
        return view('projects.create');
    }

    // Store a new project
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'tasks' => 'required|array',
            'tasks.*' => 'required|string|max:255',
            'members' => 'nullable|array',
            'members.*' => 'nullable|email|exists:users,email',
        ]);

        // Create a new project
        $project = Project::create([
            'title' => $request->title,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'user_id' => Auth::id(),
        ]);

        // Create tasks for this project
        foreach ($request->tasks as $task) {
            Task::create([
                'task_name' => $task,
                'project_id' => $project->id,
                'task_details' => 'No details provided', // Default value
        ]);
    }
        
        // Attach members to the project
        if ($request->members) {
            $members = User::whereIn('email', $request->members)->pluck('id');
            $project->members()->attach($members);
        }

        return redirect()->route('dashboard')->with('success', 'Project created successfully!');
    }

    // Show the project edit form
    public function edit($id)
    {
        $project = Project::with('tasks')->findOrFail($id);

        // Ensure the logged-in user is the owner or a member of the project
        if ($project->user_id != Auth::id() && !$project->members->contains(Auth::id())) {
            return redirect()->route('projects.index')->with('error', 'You are not authorized to edit this project.');
        }

        return view('projects.edit', compact('project'));
    }

    // Update the project details
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'tasks' => 'nullable|array',
            'tasks.*.id' => 'nullable|integer|exists:tasks,id',
            'tasks.*.task_name' => 'nullable|string|max:255',
            'members' => 'nullable|array',
            'members.*' => 'nullable|email|exists:users,email',
        ]);

        $project = Project::findOrFail($id);

        // Ensure the logged-in user is the owner or a member of the project
        if ($project->user_id != Auth::id() && !$project->members->contains(Auth::id())) {
            return redirect()->route('projects.index')->with('error', 'You are not authorized to update this project.');
        }

        $project->update([
            'title' => $request->title,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        // Update tasks
        if ($request->tasks) {
            foreach ($request->tasks as $taskData) {
                if (is_array($taskData) && isset($taskData['id'])) {
                    // Update existing task
                    $task = Task::findOrFail($taskData['id']);
                    $task->update([
                        'task_name' => $taskData['task_name'],
                    ]);
                } elseif (is_string($taskData)) {
                    // Add new task if $taskData is a string
                    Task::create([
                        'task_name' => $taskData,
                        'project_id' => $project->id,
                        'task_details' => $taskData,
                    ]);
                }
            }
        }
        
                

        // Update members
        if ($request->members) {
            $members = User::whereIn('email', $request->members)->pluck('id');
            $project->members()->sync($members);
        }

        return redirect()->route('projects.index')->with('success', 'Project updated successfully!');
    }

    // Delete the project
    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        // Ensure the logged-in user is the owner of the project
        if ($project->user_id != Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to delete this project.');
        }

        $project->delete();
        return redirect()->route('dashboard')->with('success', 'Project deleted successfully!');
    }
}
