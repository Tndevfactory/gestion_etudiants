<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @param mixed ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles): mixed
    {
        $user = Auth::user();

        if (!$user || !$user->role) {
            abort(403, 'Accès interdit.');
        }

        // Vérifier si l'utilisateur a un rôle autorisé
        if (!in_array($user->role->name, $roles)) {
            abort(403, 'Vous n’avez pas les droits nécessaires.');
        }

        return $next($request);
    }
}
