<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        // si tout va bien redirection vers dashboard
        // confirmation d'inscription
        return view('auth.register');
    }

    public function login(Request $request)
    {     // Request data envoyer par le formulaire
          // si tout va bien redirection vers dashboard
        return view('auth.register');
    }

    public function logout()
    {
        // a la fin du logout redirection vers login page
        return view('auth.register');
    }

}
