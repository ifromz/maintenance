<?php

namespace Stevebauman\Maintenance\Http\Middleware;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Closure;
use Illuminate\Http\Request;
use Stevebauman\Maintenance\Models\User;

class PermissionMiddleware
{
    /**
     * Throws 403 unauthorized error if the user is
     * not allowed to access the specified route.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return Request
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Sentinel::getUser();

        if ($user && $user instanceof User) {
            if ($user->hasAccess($request->route()->getName())) {
                return $next($request);
            }
        }

        // Return forbidden error.
        abort(403);
    }
}
