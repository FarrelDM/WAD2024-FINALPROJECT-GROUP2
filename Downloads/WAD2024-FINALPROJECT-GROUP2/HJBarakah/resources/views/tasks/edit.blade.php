@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Task</h1>
    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="task_name" class="form-label">Task Name</label>
            <input type="text" name="task_name" id="task_name" class="form-control" value="{{ $task->task_name }}" required>
        </div>

        <div class="mb-3">
            <label for="task_details" class="form-label">Task Details</label>
            <textarea name="task_details" id="task_details" class="form-control">{{ $task->task_details }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Task</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
