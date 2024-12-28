<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles and Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel ="stylesheet" href="{{asset('css/role.css')}}">
</head>
<body class="bg-light">
    <!-- Header with Dashboard Link -->
    <header class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">HJ Barakah</a>
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

    <div class="container mt-5">
        <h1>Roles and Assigned Users</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- List of roles with assigned users -->
        @if ($roles->isEmpty())
            <p>No roles found. Please create some roles first.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Assigned Users</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>
                                @forelse($role->users as $user)
                                    <span class="badge bg-primary">{{ $user->name }}</span>
                                @empty
                                    <span class="text-muted">No users assigned</span>
                                @endforelse
                            </td>
                            <td>
                                <!-- Assign Users Button -->
                                <a href="{{ route('roles.assignUserForm', $role->id) }}" class="btn btn-sm btn-success">Assign Users</a>
                                <!-- Delete Role Button -->
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- Button to create a new role -->
        <a href="{{ route('roles.create') }}" class="btn btn-primary">Create New Role</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
