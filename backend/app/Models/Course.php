<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
     protected $fillable = ['name', 'description', 'teacher_id'];
  // Lien vers le professeur
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    // Many-to-Many vers étudiants via student_course
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_course')
                    ->withPivot('grade')
                    ->withTimestamps();
    }

}
