<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Users to Role</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
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

        <!-- Link to go back to roles list -->
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back to Roles List</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
