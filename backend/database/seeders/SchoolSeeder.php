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

        // Quelques images libres (avatars & cours)
        $userImages = [
            'prof1' => 'https://randomuser.me/api/portraits/men/32.jpg',
            'prof2' => 'https://randomuser.me/api/portraits/men/44.jpg',
            'alice' => 'https://randomuser.me/api/portraits/women/68.jpg',
            'bob'   => 'https://randomuser.me/api/portraits/men/12.jpg',
            'claire'=> 'https://randomuser.me/api/portraits/women/21.jpg',
        ];

        $courseImages = [
            'math' => 'https://img.icons8.com/color/96/000000/math.png',
            'algo' => 'https://img.icons8.com/color/96/000000/artificial-intelligence.png',
            'web'  => 'https://img.icons8.com/color/96/000000/web-design.png',
        ];

        // 2️⃣ Créer deux professeurs avec image
        $prof1User = User::firstOrCreate(
            ['email' => 'prof1@example.com'],
            [
                'name' => 'Professeur Dupont',
                'password' => Hash::make('password'),
                'role_id' => $roles['teacher']->id,
                'image'   => $userImages['prof1']
            ]
        );
        $prof1 = Teacher::firstOrCreate(['id' => $prof1User->id], [
            'phone' => '11111111',
            'specialty' => 'Mathématiques'
        ]);

        $prof2User = User::firstOrCreate(
            ['email' => 'prof2@example.com'],
            [
                'name' => 'Professeur Durand',
                'password' => Hash::make('password'),
                'role_id' => $roles['teacher']->id,
                'image'   => $userImages['prof2']
            ]
        );
        $prof2 = Teacher::firstOrCreate(['id' => $prof2User->id], [
            'phone' => '22222222',
            'specialty' => 'Informatique'
        ]);

        // 3️⃣ Créer trois étudiants avec image
        $students = collect([
            ['name' => 'Alice Martin', 'email' => 'alice@example.com', 'dob' => '2002-04-12', 'phone' => '33333333', 'image' => $userImages['alice']],
            ['name' => 'Bob Leroy', 'email' => 'bob@example.com', 'dob' => '2001-09-21', 'phone' => '44444444', 'image' => $userImages['bob']],
            ['name' => 'Claire Dubois', 'email' => 'claire@example.com', 'dob' => '2003-01-05', 'phone' => '55555555', 'image' => $userImages['claire']],
        ])->map(function ($data) use ($roles) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role_id' => $roles['student']->id,
                    'image'   => $data['image']
                ]
            );
            return Student::firstOrCreate(
                ['id' => $user->id],
                ['date_of_birth' => $data['dob'], 'phone' => $data['phone']]
            );
        });

        // 4️⃣ Créer des cours avec image
        $math = Course::firstOrCreate(
            ['name' => 'Algèbre'],
            ['description' => 'Cours de base', 'teacher_id' => $prof1->id, 'image' => $courseImages['math']]
        );
        $algo = Course::firstOrCreate(
            ['name' => 'Algorithmique'],
            ['description' => 'Introduction aux algos', 'teacher_id' => $prof2->id, 'image' => $courseImages['algo']]
        );
        $web  = Course::firstOrCreate(
            ['name' => 'Développement Web'],
            ['description' => 'HTML, CSS, Laravel', 'teacher_id' => $prof2->id, 'image' => $courseImages['web']]
        );

        // 5️⃣ Inscrire les étudiants dans les cours avec image sur pivot
        $students[0]->courses()->syncWithoutDetaching([
            $math->id => ['image' => 'https://img.icons8.com/color/96/000000/student-female.png'],
            $algo->id => ['image' => 'https://img.icons8.com/color/96/000000/student-female.png'],
        ]);

        $students[1]->courses()->syncWithoutDetaching([
            $algo->id => ['image' => 'https://img.icons8.com/color/96/000000/student-male.png'],
            $web->id  => ['image' => 'https://img.icons8.com/color/96/000000/student-male.png'],
        ]);

        $students[2]->courses()->syncWithoutDetaching([
            $math->id => ['image' => 'https://img.icons8.com/color/96/000000/student-female.png'],
            $web->id  => ['image' => 'https://img.icons8.com/color/96/000000/student-female.png'],
        ]);
    }
}
