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
    public function register()
    {
        // si tout va bien redirection vers dashboard
        return view('auth.register');
    }

    public function login()
    {
          // si tout va bien redirection vers dashboard
        return view('auth.register');
    }

    public function logout()
    {
        // a la fin du logout redirection vers login page
        return view('auth.register');
    }

}
