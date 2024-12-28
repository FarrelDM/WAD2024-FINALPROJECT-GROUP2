
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel ="stylesheet" href="{{asset('css/taskdetails.css')}}">

</head>

<body> 
<!-- Updated Navbar -->
<header class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">HJ Barakah</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/new-project">New Project</a></li>
                <li class="nav-item"><a class="nav-link" href="/calendar">Calendar</a></li>
                <li class="nav-item"><a class="nav-link" href="/roles">Roles</a></li>
                <li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>
            </ul>
        </div>
    </div>
</header>
<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Task Details</h1>
        <!-- Cancel Edit Button aligned with Task Details -->
        <a href="{{ route('dashboard') }}" class="btn btn-danger text-white">Cancel Edit</a>
    </div>

    <!-- Task Information -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $task->task_name }}</h5>
            <p class="card-text">{{ $task->task_details }}</p>
        </div>
    </div>

    <!-- Edit Task Form -->
    <h3>Edit Task</h3>
    <form action="{{ route('tasks.update', $task->id) }}" method="POST" id="taskForm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="task_name" class="form-label">Task Name</label>
            <input type="text" name="task_name" id="task_name" class="form-control" value="{{ $task->task_name }}" required>
        </div>

        <div class="mb-3">
            <label for="task_details" class="form-label">Task Details</label>
            <textarea name="task_details" id="task_details" class="form-control" required>{{ $task->task_details }}</textarea>
        </div>
    </form>

    <!-- Roles Section -->
    <h3 class="mt-5">Assign Roles</h3>
    <form action="{{ route('tasks.assign_roles', $task->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="roles" class="form-label">Select Roles</label>
            <select name="roles[]" id="roles" class="form-control" multiple>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" 
                        {{ $task->roles->contains($role->id) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Assign Roles</button>
    </form>

    <!-- Display Assigned Roles -->
    <ul>
        @foreach($task->roles as $role)
            <li>{{ $role->name }} (ID: {{ $role->id }})</li>
        @endforeach
    </ul>
    
    <!-- Save Changes Button Below "Assign Roles" -->
    <div class="d-flex justify-content-end mt-3">
        <button type="submit" form="taskForm" class="btn btn-primary">Save Changes</button>
    </div>
</div>
</body>

