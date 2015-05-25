<?php

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;

/*
 * Filter to protect against unauthorized users
 * Redirects users to main login
 */
Route::filter('maintenance.auth', function () {
    if (!Sentry::check()) {
        Session::put('url.intended', URL::full());

        return Redirect::route('maintenance.login');
    }
});

/*
 * Filter to prevent users from visiting the login/register pages
 * when logged in. Redirects user to main dashboard
 */
Route::filter('maintenance.notauth', function () {
    if (Sentry::check()) {
        return Redirect::route('maintenance.dashboard.index');
    }
});

/*
 * Filter to protect routes to make sure the current user has access to it.
 */
Route::filter('maintenance.permission', function (\Illuminate\Routing\Route $route)
{
    $user = Sentry::getUser();

    /*
     * Make sure the route we're on isn't allowing all users already, and if so we'll check to see
     * if the current user has access to it
     */
    if (!in_array($route->getName(), config('maintenance::permissions.all_users')) && !$user->hasAccess($route->getName())) {
        $message = 'You do not have access to do perform this function.';
        $messageType = 'danger';

        /*
         * If an ajax request is performed, return the response so the user knows what happened.
         */
        if (Request::ajax()) {
            return Response::json([
                'message' => $message,
                'messageType' => $messageType,
            ]);
        } else {
            $previousUrl = URL::previous();

            if($previousUrl) {
                $redirect = $previousUrl;
            } else {
                $redirect = '/';
            }

            return Redirect::to($redirect);
        }
    }
});
