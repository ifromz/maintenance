<?php

namespace Stevebauman\Maintenance\Http\Middleware;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Closure;
use Illuminate\Http\Request;

class AuthMiddleware
{
    /**
     * Redirects unauthenticated users to the login page.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return Request|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Sentinel::check()) {
            return $next($request);
        } else {
            $message = "You're not logged in.";

            return redirect()->route('maintenance.login')->withErrors($message);
        }
    }
}
