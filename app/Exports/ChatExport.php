<?php

namespace App\Exports;

use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ChatExport implements FromCollection, WithHeadings
{
    protected $currentUserId;
    protected $selectedUserId;

    public function __construct($currentUserId, $selectedUserId)
    {
        $this->currentUserId = $currentUserId;
        $this->selectedUserId = $selectedUserId;
    }

    public function collection()
    {
        return Chat::where(function ($query) {
            $query->where('user_id', $this->currentUserId)
                  ->where('receiver_id', $this->selectedUserId);
        })
        ->orWhere(function ($query) {
            $query->where('user_id', $this->selectedUserId)
                  ->where('receiver_id', $this->currentUserId);
        })
        ->orderBy('created_at', 'asc')
        ->get(['user_id', 'receiver_id', 'message', 'created_at']);
    }

    public function headings(): array
    {
        return ['Sender ID', 'Receiver ID', 'Message', 'Sent At'];
    }
}
