<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Create New Project</h1>
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Project Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" name="status" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>

            <div id="task-container" class="mb-3">
                <label for="tasks" class="form-label">Add Tasks</label>
                <input type="text" name="tasks[]" class="form-control mb-2" placeholder="Task Name" required>
                <button type="button" id="add-task" class="btn btn-secondary mt-2">Add Another Task</button>
            </div>

            <div id="member-container" class="mb-3">
                <label for="members" class="form-label">Add Members (Email)</label>
                <input type="email" name="members[]" class="form-control mb-2" placeholder="Member Email">
                <button type="button" id="add-member" class="btn btn-secondary mt-2">Add Another Member</button>
            </div>

            <button type="submit" class="btn btn-primary">Save Project</button>
            <a href="{{ route('dashboard') }}" class="btn btn-danger">Cancel</a>
        </form>
    </div>

    <script>
        document.getElementById('add-task').addEventListener('click', function() {
            const taskInput = document.createElement('input');
            taskInput.type = 'text';
            taskInput.name = 'tasks[]';
            taskInput.classList.add('form-control', 'mb-2');
            taskInput.placeholder = 'Task Name';
            taskInput.required = true;
            this.before(taskInput);
        });

        document.getElementById('add-member').addEventListener('click', function() {
            const memberInput = document.createElement('input');
            memberInput.type = 'email';
            memberInput.name = 'members[]';
            memberInput.classList.add('form-control', 'mb-2');
            memberInput.placeholder = 'Member Email';
            this.before(memberInput);
        });
    </script>
</body>
</html>
