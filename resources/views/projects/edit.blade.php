<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <header class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">HJ Barakah</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/dashboard">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </header>

    <main class="container py-5">
        <h1 class="h3 mb-4">Edit Project</h1>

        <form action="{{ route('projects.update', $project->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Project Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $project->title) }}" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" class="form-control" id="status" name="status" value="{{ old('status', $project->status) }}" required>
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">Due Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', $project->end_date->format('Y-m-d')) }}" required>
            </div>

            <h4 class="mt-4">Current Tasks</h4>
            @foreach($project->tasks as $task)
                <div class="mb-3">
                    <label for="task_name" class="form-label">Task</label>
                    <input type="text" class="form-control" name="tasks[{{ $task->id }}][task_name]" value="{{ $task->task_name }}" required>
                    <input type="hidden" name="tasks[{{ $task->id }}][id]" value="{{ $task->id }}">
                    <input type="hidden" name="tasks[{{ $task->id }}][status]" value="{{ $task->status }}">
                </div>
            @endforeach

            <h4 class="mt-4">Add New Tasks</h4>
            <div id="new-tasks">
                <div class="mb-3">
                    <label for="task_name" class="form-label">New Task</label>
                    <input type="text" class="form-control" name="tasks[][task_name]" required>
                    <input type="hidden" name="tasks[][status]" value="pending">
                </div>
            </div>

            <button type="button" class="btn btn-secondary" id="add-task">Add Another Task</button>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Update Project</button>
            </div>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add new task input fields dynamically
        document.getElementById('add-task').addEventListener('click', function() {
            let newTaskField = document.createElement('div');
            newTaskField.classList.add('mb-3');
            newTaskField.innerHTML = `
                <label for="task_name" class="form-label">New Task</label>
                <input type="text" class="form-control" name="tasks[][task_name]" required>
                <input type="hidden" name="tasks[][status]" value="pending">
            `;
            document.getElementById('new-tasks').appendChild(newTaskField);
        });
    </script>
</body>
</html>
