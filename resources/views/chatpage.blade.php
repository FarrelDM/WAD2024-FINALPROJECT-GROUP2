<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-sidebar {
            max-height: 100vh;
            overflow-y: auto;
        }
        .chat-header {
            border-bottom: 1px solid #ddd;
        }
        .chat-body {
            height: calc(100vh - 180px);
            overflow-y: auto;
        }
        .chat-footer {
            position: relative;
            bottom: 0;
        }
        .chat-bubble {
            max-width: 70%;
            padding: 10px;
            border-radius: 10px;
            margin: 5px 0;
            position: relative;
            cursor: pointer;
        }
        .chat-bubble-sent {
            background-color: #d1f7d6;
            align-self: flex-end;
        }
        .chat-bubble-received {
            background-color: #f1f1f1;
            align-self: flex-start;
        }
        .chat-search {
            margin-bottom: 1rem;
        }
        .context-menu {
            display: none;
            position: absolute;
            background: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            border-radius: 5px;
        }
        .context-menu button {
            width: 100%;
            text-align: left;
            padding: 10px;
            border: none;
            background: none;
            cursor: pointer;
        }
        .context-menu button:hover {
            background-color: #f8f8f8;
        }
    </style>
</head>
<body class="bg-light">
    <header class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">HJ Barakah</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/new-project">New Project</a></li>
                    <li class="nav-item"><a class="nav-link" href="/calendar">Calendar</a></li>
                    <li class="nav-item"><a class="nav-link" href="/roles">Roles</a></li>
                    <li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </header>
    <main class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 p-0 bg-white shadow-sm chat-sidebar">
                <div class="p-3">
                    <input type="text" class="form-control chat-search" placeholder="Search chats...">
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($users as $user)
                        <li class="list-group-item d-flex align-items-center">
                            <img src="https://via.placeholder.com/40" alt="User" class="rounded-circle me-2">
                            <a href="{{ url('/chat?user=' . $user->id) }}" class="text-decoration-none flex-grow-1">
                                <span>{{ $user->name }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Chat Section -->
            <div class="col-md-9 d-flex flex-column">
                <!-- Chat Header -->
                <div class="chat-header bg-white p-3 d-flex align-items-center">
                    <img src="https://via.placeholder.com/40" alt="Selected User" class="rounded-circle me-3">
                    <h5 class="mb-0">{{ $selectedUser->name ?? 'Select a User' }}</h5>
                </div>

                <!-- Chat Body -->
                <div class="chat-body p-3 d-flex flex-column bg-light">
                    @if($selectedUser)
                        @foreach($chats as $chat)
                            @if(($chat->user_id == Auth::id() && $chat->receiver_id == $selectedUser->id) ||
                                ($chat->receiver_id == Auth::id() && $chat->user_id == $selectedUser->id))
                                <div class="d-flex {{ $chat->user_id == Auth::id() ? 'justify-content-end' : 'justify-content-start' }}">
                                    <div 
                                        class="chat-bubble {{ $chat->user_id == Auth::id() ? 'chat-bubble-sent' : 'chat-bubble-received' }}" 
                                        data-message-id="{{ $chat->id }}"
                                        oncontextmenu="showContextMenu(event, '{{ $chat->id }}', '{{ $chat->message }}')"
                                    >
                                        {{ $chat->message }}
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <p class="text-center text-muted">Please select a user to start a conversation.</p>
                    @endif
                </div>

                <!-- Chat Footer -->
                @if($selectedUser)
                    <form action="/chat/send" method="POST" class="chat-footer bg-white p-3">
                        @csrf
                        <div class="input-group">
                            <input type="hidden" name="receiver_id" value="{{ $selectedUser->id }}">
                            <input type="text" name="message" class="form-control" placeholder="Type a message..." required>
                            <button class="btn btn-primary" type="submit">Send</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </main>

    <!-- Context Menu -->
    <div id="context-menu" class="context-menu">
        <button onclick="editMessage()">Edit</button>
        <button onclick="deleteMessage()">Delete</button>
    </div>

    <script>
        let selectedMessageId = null;
        let selectedMessageText = null;

        function showContextMenu(event, messageId, messageText) {
            event.preventDefault();

            selectedMessageId = messageId;
            selectedMessageText = messageText;

            const contextMenu = document.getElementById('context-menu');
            contextMenu.style.display = 'block';
            contextMenu.style.left = `${event.pageX}px`;
            contextMenu.style.top = `${event.pageY}px`;
        }

        document.addEventListener('click', () => {
            const contextMenu = document.getElementById('context-menu');
            contextMenu.style.display = 'none';
        });

        function editMessage() {
            const newMessage = prompt('Edit your message:', selectedMessageText);
            if (newMessage && newMessage !== selectedMessageText) {
                const form = document.createElement('form');
                form.action = `/chat/${selectedMessageId}/update`;
                form.method = 'POST';

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                const messageField = document.createElement('input');
                messageField.type = 'hidden';
                messageField.name = 'message';
                messageField.value = newMessage;

                form.appendChild(csrfToken);
                form.appendChild(messageField);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function deleteMessage() {
            if (confirm('Are you sure you want to delete this message?')) {
                const form = document.createElement('form');
                form.action = `/chat/${selectedMessageId}/delete`;
                form.method = 'POST';

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';

                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>
