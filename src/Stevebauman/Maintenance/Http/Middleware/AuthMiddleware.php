<?php

namespace Stevebauman\Maintenance\Http\Middleware;

use Closure;
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
     * @param $request
     * @param Closure $next
     *
     * @return $this
     */
    public function handle($request, Closure $next)
    {
        if($this->sentry->check()) {
            $message = "You're not logged in.";

            return redirect()->route('maintenance.login')->withErrors($message);
        }

        return $next($request);
    }
}