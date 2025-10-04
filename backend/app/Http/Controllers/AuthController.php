<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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
            'role_id' => $role_student->id, // default role student
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

    // Form pour demander le reset
    public function showForgotForm()
    {
        return view('auth.passwords.email'); // crée ce fichier Blade
    }

    // Envoyer le lien de reset
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Vérifier si l'email existe avant d'appeler Password::sendResetLink
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Cet email n’existe pas dans nos enregistrements.',
            ]);
        }

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => 'Un lien de réinitialisation a été envoyé à votre adresse e-mail.'])
            : back()->withErrors(['email' => 'Une erreur est survenue, veuillez réessayer plus tard.']);
    }


    // Form pour reset avec token
    public function showResetForm(Request $request, $token)
    {
        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => $request->query('email'), // 👈 récupère l’email dans l’URL
        ]);
    }


    // Réinitialisation du mot de passe
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use($request) {
                $user->forceFill([
                    'password' => $request->password, // PAS de Hash::make ici
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        switch ($status) {
            case Password::PASSWORD_RESET:
                return redirect()->route('login')
                    ->with('status', 'Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter.');

            case Password::INVALID_USER:
                return back()->withErrors(['email' => 'Aucun compte ne correspond à cette adresse e-mail.']);

            case Password::INVALID_TOKEN:
                return back()->withErrors(['email' => 'Le lien de réinitialisation est invalide ou expiré. Veuillez refaire une demande.']);

            case Password::RESET_THROTTLED:
                return back()->withErrors(['email' => 'Trop de tentatives de réinitialisation. Veuillez patienter quelques minutes avant de réessayer.']);

            default:
                return back()->withErrors(['email' => 'Une erreur est survenue lors de la réinitialisation. Veuillez réessayer.']);
        }
    }

}
