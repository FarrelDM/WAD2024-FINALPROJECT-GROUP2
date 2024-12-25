<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'task_name',
        'task_details',
    ];

    // Relationship with the project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Relationship with roles
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_task');
    }
}
