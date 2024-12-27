<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'message', 'roles', 'task_id',
    ];

    protected $casts = [
        'roles' => 'array', // Cast JSON to an array
    ];

    public function task()
{
    return $this->belongsTo(Task::class);
}
}

