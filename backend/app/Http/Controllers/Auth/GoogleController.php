<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Erreur lors de la connexion Google');
        }

        // Vérifier si l'utilisateur existe
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // Créer un nouvel utilisateur
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(str()->random(16)), // mot de passe aléatoire
                'image' => $googleUser->getAvatar(), // <-- ici on enregistre l'URL de l'image
                'role_id' => 3, // student par défaut
            ]);
        }

        // Connecter l'utilisateur
        Auth::login($user, true);

        return redirect('/');
    }
}
