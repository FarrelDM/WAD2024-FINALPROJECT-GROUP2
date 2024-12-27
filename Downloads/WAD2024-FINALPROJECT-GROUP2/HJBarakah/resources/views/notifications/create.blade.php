@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Notification</h1>
    <form action="{{ route('notifications.store') }}" method="POST">
        @csrf

        <!-- Notification Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <!-- Notification Message -->
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea name="message" id="message" class="form-control" required></textarea>
        </div>

        <!-- Roles Dropdown -->
        <div class="mb-3">
            <label for="roles" class="form-label">Roles (Optional)</label>
            <select name="roles[]" id="roles" class="form-control" multiple>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Tasks Dropdown -->
        <div class="mb-3">
            <label for="task_id" class="form-label">Task</label>
            <select name="task_id" id="task_id" class="form-control">
                <option value="">Select Task (Optional)</option>
                @foreach ($tasks as $task)
                    <option value="{{ $task->id }}">{{ $task->task_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Save Notification</button>
    </form>
</div>
@endsection
