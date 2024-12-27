@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Task Details</h1>

    <!-- Task Information -->
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $task->task_name }}</h5>
            <p class="card-text">{{ $task->task_details }}</p>
        </div>
    </div>

    <!-- Edit Task Form -->
    <h3>Edit Task</h3>
    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="task_name" class="form-label">Task Name</label>
            <input type="text" name="task_name" id="task_name" class="form-control" value="{{ $task->task_name }}" required>
        </div>

        <div class="mb-3">
            <label for="task_details" class="form-label">Task Details</label>
            <textarea name="task_details" id="task_details" class="form-control" required>{{ $task->task_details }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
    </form>

    <!-- Roles Section -->
    <h3 class="mt-5">Assign Roles</h3>
    <form action="{{ route('tasks.assign_roles', $task->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="roles" class="form-label">Select Roles</label>
            <select name="roles[]" id="roles" class="form-control" multiple>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" 
                        {{ $task->roles->contains($role->id) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Assign Roles</button>
    </form>

    <!-- Display Assigned Roles -->
    <h4 class="mt-4">Assigned Roles</h4>
    <ul>
        @foreach($task->roles as $role)
            <li>{{ $role->name }} (ID: {{ $role->id }})</li>
        @endforeach
    </ul>
</div>
@endsection
