@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Notifications</h1>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($notifications->isNotEmpty())
        <ul class="list-group">
            @foreach ($notifications as $notification)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h5>{{ $notification->title }}</h5>
                        <p>{{ $notification->message }}</p>
                    </div>
                    <div>
                        <a href="{{ route('notifications.edit', $notification->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        
                        <!-- Delete Button -->
                        <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this notification?')">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-muted">No notifications available.</p>
    @endif
</div>
@endsection
