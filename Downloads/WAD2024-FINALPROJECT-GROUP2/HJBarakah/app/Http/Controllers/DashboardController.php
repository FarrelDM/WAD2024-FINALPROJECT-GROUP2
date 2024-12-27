<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Retrieve the authenticated user's projects and eager load tasks
        $projects = Project::where('user_id', Auth::id())
                           ->with('tasks') // Eager load tasks
                           ->get();

        return view('dashboard', compact('projects'));
    }
}



