@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Notification</h1>
    
    <!-- Update Form -->
    <form action="{{ route('notifications.update', $notification->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Notification Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $notification->title }}" required>
        </div>

        <!-- Notification Message -->
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea name="message" id="message" class="form-control" required>{{ $notification->message }}</textarea>
        </div>

        <!-- Roles Dropdown -->
        <div class="mb-3">
            <label for="roles" class="form-label">Roles (Optional)</label>
            <select name="roles[]" id="roles" class="form-control" multiple>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ in_array($role->id, $notification->roles ?? []) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Tasks Dropdown -->
        <div class="mb-3">
            <label for="task_id" class="form-label">Task</label>
            <select name="task_id" id="task_id" class="form-control">
                <option value="">Select Task (Optional)</option>
                @foreach ($tasks as $task)
                    <option value="{{ $task->id }}" {{ $notification->task_id == $task->id ? 'selected' : '' }}>
                        {{ $task->task_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Update Button -->
        <button type="submit" class="btn btn-primary">Update Notification</button>
    </form>

    <!-- Delete Button -->
    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mt-3" onclick="return confirm('Are you sure you want to delete this notification?')">
            Delete Notification
        </button>
</form>

</div>
@endsection
