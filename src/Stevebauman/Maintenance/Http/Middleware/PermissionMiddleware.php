<?php

namespace Stevebauman\Maintenance\Http\Middleware;

use Closure;
use Stevebauman\Maintenance\Models\User;
use Stevebauman\Maintenance\Services\SentryService;

class PermissionMiddleware
{
    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * Constructor.
     *
     * @param SentryService $sentry
     */
    public function __construct(SentryService $sentry)
    {
        $this->sentry = $sentry;
    }

    /**
     * Throws 401 unauthorized error if the user is
     * not allowed to access the specified route.
     *
     * @param $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $this->sentry->getCurrentUser();

        if($user && $user instanceof User) {
            if($user->hasAccess($request->route()->getName())) {
                return $next($request);
            }
        }

        // Return unauthorized error.
        abort(401);
    }
}