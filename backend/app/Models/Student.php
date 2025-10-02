<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students'; // or your real table name
   protected $fillable = [
        'id',
        'phone',
        'date_of_birth',
    ];
     // Lien vers User // 1..1 inverse
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

     // Many-to-Many vers Courses via student_course
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'student_course')
                    ->withPivot('grade')
                    ->withTimestamps();
    }
}
