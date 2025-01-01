<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Users to Role</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Header with Dashboard Link -->
    <!--
    <header class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">HJ Barakah</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('projects.create') }}">New Project</a></li>
                    <li class="nav-item"><a class="nav-link" href="/calendar">Calendar</a></li>
                    <li class="nav-item"><a class="nav-link" href="/roles">Roles</a></li>
                    <li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </header>
    -->

    <div class="container mt-5">
        <h1>Assign Users to Role: {{ $role->name }}</h1>

        <!-- Display success or error messages -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form to assign users to a role -->
        <form action="{{ route('roles.assignUser', $role->id) }}" method="POST">
            @csrf
            <!-- Hidden field to pass the role_id -->
            <input type="hidden" name="role_id" value="{{ $role->id }}">

            <div class="mb-3">
                <label for="user_ids" class="form-label">Select Users to Assign</label>
                <select name="user_ids[]" id="user_ids" class="form-control" multiple required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Assign Users</button>
        </form>

        <br>

        <!-- Button to go back to roles list -->
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back to Roles List</a>

        <!-- Button to go back to Dashboard -->
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
