<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Role</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel ="stylesheet" href="{{asset('css/notification.css')}}">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1>Create New Role</h1>

        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Role Name</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>

            <button type="submit" class="btn btn-primary">Create Role</button>
        </form>

        <br>

        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back to Roles List</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
