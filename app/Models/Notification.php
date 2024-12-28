<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /**
     * Only list columns that actually exist
     * in your 'notifications' table.
     */
    protected $fillable = [
        'title',
        'message',
        'task_id',
        'reminder_time', // include this if your DB has a 'reminder_time' column
    ];

    /**
     * A notification may be linked to a Task.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Many-to-many relationship between Notification and Role
     * stored in a pivot table (e.g., 'notification_role').
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'notification_role')
                    ->withTimestamps();
    }

    /**
     * Many-to-many relationship between Notification and User
     * (for assigning notifications to users).
     * The pivot table can also store 'is_read'.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'notification_user')
                    ->withPivot('is_read')
                    ->withTimestamps();
    }
}