<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel ="stylesheet" href="{{asset('css/dashboard.css')}}">

</head>
<body class="bg-light">
    <header class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="">HJ Barakah</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('projects.create') }}">New Project</a></li>
                    <li class="nav-item"><a class="nav-link" href="/roles">Roles</a></li>
                    <li class="nav-item"><a class="nav-link" href="/chat">Chat</a></li>
                    <li class="nav-item"><a class="nav-link logout-link" href="/logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </header>

    <main class="container py-5">
        <h1 class="h3 mb-4">Dashboard</h1>

        <!-- Notifications Section -->
        <div class="mb-5">
            <h3>Notifications</h3>
            <div id="notificationsSection" class="border p-3 bg-white rounded shadow-sm">
                <p class="text-muted">Loading notifications...</p>
            </div>
            <a href="{{ route('notifications.create') }}" class="btn btn-success mt-3">Add Notification</a>
        </div>

        <div class="row g-3">
            @foreach($projects as $project)
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $project->title }}</h5>
                            <p class="card-text">Due Date: {{ $project->end_date->format('d/m/Y') }}</p>

                            <!-- Display Project Members -->
                            @if($project->members->isNotEmpty())
                                <p class="mt-3"><strong>Members:</strong></p>
                                <ul class="list-group mb-3">
                                    @foreach($project->members as $member)
                                        <li class="list-group-item">{{ $member->email }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted mt-3">No members assigned</p>
                            @endif

                            <!-- List the tasks associated with the project -->
                            @if($project->tasks->isNotEmpty())
                                <ul class="list-group mt-3">
                                    @foreach($project->tasks as $task)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <strong>{{ $task->task_name }}</strong> - {{ $task->status }}

                                            <!-- Task Details Button -->
                                            <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-info">
                                                Task Details
                                            </a>

                                            <!-- Delete Task Button -->
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted mt-3">No tasks assigned</p>
                            @endif

                            <!-- Edit Project Button -->
                            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary mt-3">+</a>

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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const notificationsSection = document.getElementById('notificationsSection');

            fetch('/notifications')
                .then(response => response.json())
                .then(data => {
                    notificationsSection.innerHTML = ''; // Clear the loading message

                    if (data.length > 0) {
                        data.forEach(notification => {
                            const item = document.createElement('div');
                            item.classList.add('card', 'mb-3');
                            item.innerHTML = `
                                <div class="card-body">
                                    <h5 class="card-title">${notification.title}</h5>
                                    <p class="card-text">${notification.message}</p>
                                    <a href="/notifications/${notification.id}/edit" class="btn btn-primary btn-sm">Edit</a>
                                </div>
                            `;
                            notificationsSection.appendChild(item);
                        });
                    } else {
                        notificationsSection.innerHTML = '<p class="text-muted">No notifications available.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error loading notifications:', error);
                    notificationsSection.innerHTML = '<p class="text-danger">Failed to load notifications.</p>';
                });
        });
    </script>
</body>
</html>
