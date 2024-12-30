<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel ="stylesheet" href="{{asset('css/editproject.css')}}">

</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Edit Project</h1>
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('projects.update', $project->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Project Details -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Project Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ $project->title }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="Not Completed" {{ $project->status == 'Not Completed' ? 'selected' : '' }}>Not Completed</option>
                            <option value="On-going" {{ $project->status == 'On-going' ? 'selected' : '' }}>On-going</option>
                            <option value="Completed" {{ $project->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="datetime-local" name="start_date" id="start_date" class="form-control" value="{{ $project->start_date->format('Y-m-d\TH:i') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="datetime-local" name="end_date" id="end_date" class="form-control" value="{{ $project->end_date->format('Y-m-d\TH:i') }}" required>
                        </div>
                    </div>

                    <!-- Members -->
                    <div class="mb-3">
                        <label for="members" class="form-label">Project Members</label>
                        <div id="member-fields">
                            @foreach ($project->members as $member)
                                <div class="d-flex mb-2">
                                    <input type="email" name="members[]" value="{{ $member->email }}" class="form-control me-2" readonly>
                                    <button type="button" class="btn btn-outline-danger btn-sm remove-member">Remove</button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-member" class="btn btn-outline-secondary btn-sm">+ Add Member</button>
                    </div>

                    <!-- Tasks -->
                    <div class="mb-3">
                        <label for="tasks" class="form-label">Project Tasks</label>
                        <div id="task-fields">
                            @foreach ($project->tasks as $task)
                                <div class="d-flex mb-2">
                                    <input type="text" name="tasks[{{ $task->id }}]" value="{{ $task->task_name }}" class="form-control me-2" required>
                                    <button type="button" class="btn btn-outline-danger btn-sm remove-task">Remove</button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-task" class="btn btn-outline-secondary btn-sm">+ Add Task</button>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Update Project</button>
                        <a href="/dashboard" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Add dynamic member fields
        document.getElementById('add-member').addEventListener('click', function () {
            const memberField = document.createElement('input');
            memberField.type = 'email';
            memberField.name = 'members[]';
            memberField.className = 'form-control mb-2';
            memberField.placeholder = 'Enter member email';
            document.getElementById('member-fields').appendChild(memberField);
        });

        // Add dynamic task fields
        document.getElementById('add-task').addEventListener('click', function () {
            const taskField = document.createElement('input');
            taskField.type = 'text';
            taskField.name = 'tasks[]';
            taskField.className = 'form-control mb-2';
            taskField.placeholder = 'Task Name';
            document.getElementById('task-fields').appendChild(taskField);
        });

        // Remove member field
        document.querySelectorAll('.remove-member').forEach(button => {
            button.addEventListener('click', function () {
                this.parentElement.remove();
            });
        });

        // Remove task field
        document.querySelectorAll('.remove-task').forEach(button => {
            button.addEventListener('click', function () {
                this.parentElement.remove();
            });
        });
    </script>
</body>
</html>
