<?php

namespace Stevebauman\Maintenance\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
     * Throws 403 unauthorized error if the user is
     * not allowed to access the specified route.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return Request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $this->sentry->getCurrentUser();

        if($user && $user instanceof User) {
            if($user->hasAccess($request->route()->getName())) {
                return $next($request);
            }
        }

        // Return forbidden error.
        abort(403);
    }
}
