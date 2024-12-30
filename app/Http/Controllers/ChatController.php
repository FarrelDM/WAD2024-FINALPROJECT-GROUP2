<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ChatExport;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('id', '!=', Auth::id())->get();

        $selectedUser = null;
        if ($request->has('user')) {
            $selectedUser = User::find($request->user);
        }

        $chats = Chat::where(function ($query) {
            $query->where('user_id', Auth::id())
                  ->orWhere('receiver_id', Auth::id());
        })
        ->orderBy('created_at', 'asc')
        ->get();

        return view('chatpage', compact('users', 'selectedUser', 'chats'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:255',
        ]);

        Chat::create([
            'user_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return redirect()->back();
    }

    public function updateMessage(Request $request, $id)
    {
        $chat = Chat::findOrFail($id);

        if ($chat->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $chat->update([
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Message updated successfully.');
    }

    public function deleteChat($id)
    {
        $chat = Chat::findOrFail($id);

        if ($chat->user_id == Auth::id() || $chat->receiver_id == Auth::id()) {
            $chat->delete();
        }

        return redirect()->back();
    }

    public function addUser(Request $request)
    {
        // Additional functionality if needed for adding a user
        return redirect()->back();
    }

    public function removeUser($id)
    {
        // Additional functionality if needed for removing a user
        return redirect()->back();
    }

    public function exportChatLog(Request $request)
    {
        $selectedUserId = $request->query('user');

        if (!$selectedUserId) {
            return redirect()->back()->with('error', 'Please select a user to export chat logs.');
        }

        $selectedUser = User::find($selectedUserId);

        if (!$selectedUser) {
            return redirect()->back()->with('error', 'User not found.');
        }

        return Excel::download(new ChatExport(Auth::id(), $selectedUserId), 'chat-log.xlsx');
    }
}
