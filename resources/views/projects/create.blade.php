<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Create New Project</h1>

        <form action="{{ route('projects.store') }}" method="POST">
            @csrf

            <!-- Project Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Project Title</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" name="status" id="status" class="form-control" required>
            </div>

            <!-- Start Date -->
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="datetime-local" name="start_date" id="start_date" class="form-control" required>
            </div>

            <!-- End Date -->
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="datetime-local" name="end_date" id="end_date" class="form-control" required>
            </div>

            <!-- Tasks -->
            <div class="mb-3">
                <label for="tasks" class="form-label">Add Tasks</label>
                <input type="text" name="tasks[]" class="form-control" placeholder="Task 1" required>
                <input type="text" name="tasks[]" class="form-control mt-2" placeholder="Task 2" required>
                <input type="text" name="tasks[]" class="form-control mt-2" placeholder="Task 3" required>
            </div>

            <button type="submit" class="btn btn-primary">Save Project</button>
        </form>
    </div>
</body>
</html>
