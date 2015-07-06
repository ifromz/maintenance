<?php

namespace Stevebauman\Maintenance\Http\Middleware;

use Closure;
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
     * @param $request
     * @param Closure $next
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if($this->sentry->check()) {
            return redirect()->route('maintenance.dashboard.index');
        } else {
            return $next($request);
        }
    }
}