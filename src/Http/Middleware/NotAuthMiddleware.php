<?php

namespace Stevebauman\Maintenance\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class NotAuthMiddleware
{
    /**
     * Redirects users to the main dashboard page if they're
     * already logged in and trying to access a login / register route.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return Request|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Sentinel::getUser();

        if($user) {
            $route = 'maintenance.work-requests.index';

            if(! $user->hasAccess($route)) {
                $route = 'maintenance.client.work-requests.index';
            }

            return redirect()->route($route);
        } else {
            return $next($request);
        }
    }
}