<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
                    <li class="nav-item"><a class="nav-link" href="{{ route('projects.create') }}">New Project</a></li> <!-- Link to New Project -->
                    <li class="nav-item"><a class="nav-link" href="/calendar">Calendar</a></li>
                    <li class="nav-item"><a class="nav-link" href="/roles">Roles</a></li>
                    <li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </header>

    <main class="container py-5">
        <h1 class="h3 mb-4">Dashboard</h1>

        <div class="row g-3">
            @foreach($projects as $project)
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $project->title }}</h5>
                            <p class="card-text">Due Date: {{ $project->end_date->format('d/m/Y') }}</p>

                            <!-- Task Progress -->
                            <div class="progress">
                                @php
                                    $totalTasks = $project->tasks->count();
                                    $completedTasks = $project->tasks->where('status', 'completed')->count();
                                    $progress = $totalTasks ? ($completedTasks / $totalTasks) * 100 : 0;
                                @endphp
                                <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">{{ round($progress) }}%</div>
                            </div>

                            <!-- List the tasks associated with the project -->
                            @if($project->tasks->isNotEmpty())
                                <ul class="list-group mt-3">
                                    @foreach($project->tasks as $task)
                                        <li class="list-group-item">
                                            <strong>{{ $task->task_name }}</strong> - {{ $task->status }}  <!-- Change title to task_name -->
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted mt-3">No tasks assigned</p>
                            @endif

                            <!-- Edit Project Button -->
                            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary mt-3">Edit Project</a>

                            <!-- Delete Project Button -->
                            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mt-3">Delete Project</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
