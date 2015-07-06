<?php

namespace Stevebauman\Maintenance\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stevebauman\Maintenance\Services\SentryService;

class AuthMiddleware
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
     * Redirects unauthenticated users to the login page.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return Request|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($this->sentry->check()) {
            return $next($request);
        } else {
            $message = "You're not logged in.";

            return redirect()->route('maintenance.login')->withErrors($message);
        }
    }
}