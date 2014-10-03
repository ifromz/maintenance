<?php

/**
 * Filter to protect against unauthorized users
 * Redirects users to main login
 *
 * @author Steve Bauman
 */
Route::filter('maintenance.auth', function($route, $request){
    if(!Sentry::check()) {
        Session::put('url.intended', URL::full());
        return Redirect::route('maintenance.login');
    }
});

/**
 * Filter to protect against authorized users.
 * Redirects user to main dashboard
 *
 * @author Steve Bauman
 */
Route::filter('maintenance.notauth', function($route, $request){
	if(Sentry::check()) {
		return Redirect::route('maintenance.dashboard.index');
	}
});

Route::filter('maintenance.permission', function($route, $request){ 
    /*
    if(Sentry::getUser()->hasAccess(Route::currentRouteName())){
        return Response::json(array('message'=>'User does have access'));
    } else{
        return Response::json(array('message'=>'User does not have access'));
    }
     * 
     */
});

/**
 * Filter to check if the URL Slug is valid
 *
 * @author Steve Bauman
 */
Route::filter('maintenance.valid.work-order', 'Stevebauman\Maintenance\Filters\WorkOrderFilter');