<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Mass assignable attributes
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Attributes to be hidden for arrays
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Relationships or other methods
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
