<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;  // Import Carbon for date handling

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status',
        'start_date',
        'end_date',
        'user_id',
    ];

    // Add this cast property to automatically convert the date fields to Carbon instances
    protected $casts = [
        'start_date' => 'datetime',  // Cast start_date to Carbon instance
        'end_date' => 'datetime',    // Cast end_date to Carbon instance
    ];

    // Relationship with tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // Relationship with the user who created the project
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function members()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }
    
}
