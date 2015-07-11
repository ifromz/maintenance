<?php

namespace Stevebauman\Maintenance\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stevebauman\Maintenance\Services\SentryService;

class NotAuthMiddleware
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
        if($this->sentry->check()) {
            $currentUser = $this->sentry->getCurrentUser();

            $route = 'maintenance.work-requests.index';

            if(! $currentUser->hasAccess($route)) {
                $route = 'maintenance.client.work-requests.index';
            }

            return redirect()->route($route);
        } else {
            return $next($request);
        }
    }
}