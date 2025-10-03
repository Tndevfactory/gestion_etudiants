<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;

class AuthController extends Controller
{
    // views
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    // logique
    public function register(Request $request)
    {
        // validation
        $role_student = \App\Models\Role::where('name', 'student')->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // save to database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'image' => "https://placehold.jp/150x150.png",
            'role_id' => $role_student->id , // default role student
        ]);

        Auth::login($user);

        return redirect()->route('dashboard.student');
    }

    public function login(Request $request)
    {
        $role_student = \App\Models\Role::where('name', 'student')->first();
        $role_teacher = \App\Models\Role::where('name', 'teacher')->first();
        $role_admin = \App\Models\Role::where('name', 'admin')->first();
        // Validate the input
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Check the user's role and redirect accordingly
            if ($user->role->name === $role_admin->name) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role->name === $role_teacher->name) {
                return redirect()->route('dashboard.teacher');
            } elseif ($user->role->name === $role_student->name) {
                return redirect()->route('dashboard.student');
            } else {
                return redirect()->route('home');
            }
        }

        return back()->withErrors([
            'email' => 'Email incorrect',
            'password' => 'Mot de passe incorrect',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
