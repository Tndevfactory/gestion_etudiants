<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1️⃣ Créer les rôles
        $roles = [
            'admin'   => Role::firstOrCreate(['name' => 'admin']),
            'teacher' => Role::firstOrCreate(['name' => 'teacher']),
            'student' => Role::firstOrCreate(['name' => 'student']),
        ];

        // 2️⃣ Créer deux professeurs
        $prof1User = User::firstOrCreate(
            ['email' => 'prof1@example.com'],
            ['name' => 'Professeur Dupont', 'password' => Hash::make('password'), 'role_id' => $roles['teacher']->id]
        );
        $prof1 = Teacher::firstOrCreate(['id' => $prof1User->id], ['phone' => '11111111', 'specialty' => 'Mathématiques']);

        $prof2User = User::firstOrCreate(
            ['email' => 'prof2@example.com'],
            ['name' => 'Professeur Durand', 'password' => Hash::make('password'), 'role_id' => $roles['teacher']->id]
        );
        $prof2 = Teacher::firstOrCreate(['id' => $prof2User->id], ['phone' => '22222222', 'specialty' => 'Informatique']);

        // 3️⃣ Créer trois étudiants
        $students = collect([
            ['name' => 'Alice Martin', 'email' => 'alice@example.com', 'dob' => '2002-04-12', 'phone' => '33333333'],
            ['name' => 'Bob Leroy', 'email' => 'bob@example.com', 'dob' => '2001-09-21', 'phone' => '44444444'],
            ['name' => 'Claire Dubois', 'email' => 'claire@example.com', 'dob' => '2003-01-05', 'phone' => '55555555'],
        ])->map(function ($data) use ($roles) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                ['name' => $data['name'], 'password' => Hash::make('password'), 'role_id' => $roles['student']->id]
            );
            return Student::firstOrCreate(
                ['id' => $user->id],
                ['date_of_birth' => $data['dob'], 'phone' => $data['phone']]
            );
        });

        // 4️⃣ Créer des cours
        $math = Course::firstOrCreate(['name' => 'Algèbre'], ['description' => 'Cours de base', 'teacher_id' => $prof1->id]);
        $algo = Course::firstOrCreate(['name' => 'Algorithmique'], ['description' => 'Introduction aux algos', 'teacher_id' => $prof2->id]);
        $web  = Course::firstOrCreate(['name' => 'Développement Web'], ['description' => 'HTML, CSS, Laravel', 'teacher_id' => $prof2->id]);

        // 5️⃣ Inscrire les étudiants dans les cours
        $students[0]->courses()->syncWithoutDetaching([$math->id, $algo->id]); // Alice
        $students[1]->courses()->syncWithoutDetaching([$algo->id, $web->id]);  // Bob
        $students[2]->courses()->syncWithoutDetaching([$math->id, $web->id]);  // Claire
    }
}
