<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

     // Un rôle a plusieurs utilisateurs
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
