<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teachers'; // or your real table name
     protected $fillable = ['id', 'phone', 'specialty'];

      // Lien vers User
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
     // Un professeur peut avoir plusieurs cours
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
