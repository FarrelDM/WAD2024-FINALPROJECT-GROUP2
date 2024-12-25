<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];

    // Define many-to-many relationship with User
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    // Define many-to-many relationship with Task
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'role_task');
    }
}
