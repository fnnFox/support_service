<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class CheckUserRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }

		$user = auth()->user();

        // на всякий случай приводим к нижнему регистру
        $userRole = strtolower($user->role);
        $roles = array_map('strtolower', $roles);

        if (!in_array($userRole, $roles)) {
            abort(403, 'У вас нет прав для доступа к этой странице.');
        }

        return $next($request);
    }
}

