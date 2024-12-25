<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    // Show the list of all projects
    public function index()
    {
        $projects = Project::with('tasks')->where('user_id', Auth::id())->get();
        return view('projects.index', compact('projects'));
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
                'task_details' => $task, // Can be adjusted if task details are separate
            ]);
        }

        // Redirect to dashboard after project is created
        return redirect()->route('dashboard')->with('success', 'Project created successfully!');
    }

    // Show the project edit form
    public function edit($id)
    {
        $project = Project::findOrFail($id);

        // Ensure the logged-in user is the owner of the project
        if ($project->user_id != Auth::id()) {
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
        ]);

        $project = Project::findOrFail($id);

        // Ensure the logged-in user is the owner of the project
        if ($project->user_id != Auth::id()) {
            return redirect()->route('projects.index')->with('error', 'You are not authorized to update this project.');
        }

        $project->update([
            'title' => $request->title,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

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
