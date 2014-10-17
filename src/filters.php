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
    
    if(!Sentry::getUser()->hasAccess(Route::currentRouteName())){
        
        $message = 'You do not have access to do perform this function.';
        $messageType = 'danger';
        
        if(Request::ajax()){
            return Response::json(array(
                'message'=>$message,
                'messageType'=>$messageType
            ));  
        } else{
            return Redirect::route('maintenance.permission-denied.index')
                    ->with('message', $message)
                    ->with('messageType', $messageType);
        }
    }
    
});

/**
 * Filter to check if the URL Slug is valid
 *
 * @author Steve Bauman
 */
Route::filter('maintenance.valid.work-order', 'Stevebauman\Maintenance\Filters\WorkOrderFilter');