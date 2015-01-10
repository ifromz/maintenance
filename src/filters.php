<?php

/**
 * Filter to protect against unauthorized users
 * Redirects users to main login
 *
 * @author Steve Bauman
 */
Route::filter('maintenance.auth', function(){
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
Route::filter('maintenance.notauth', function(){
    if(Sentry::check()) {
        return Redirect::route('maintenance.dashboard.index');
    }
});

/**
 * Filter to protect routes to make sure the current user has access to it.
 *
 * @author Steve Bauman
 */
Route::filter('maintenance.permission', function(\Illuminate\Routing\Route $route){
    
    if(!Sentry::hasAccess($route->getName())){
        
        $message = 'You do not have access to do perform this function.';
        $messageType = 'danger';
        
        /*
         * If an ajax request is performed, return the response so the user knows what happened.
         */
        if(Request::ajax()){
            return Response::json(array(
                'message'=>$message,
                'messageType'=>$messageType
            ));  
        } else{
            
            /*
            * Since the auth filter redirects to the dashboard, we will redirect a user to
            * their work requests if they do not have permission since this will mean they are a
            * regular user.
            */
            if(!Sentry::hasAccess('maintenance.dashboard.index')){
                
                return Redirect::route('maintenance.work-requests.index');
                
            } else{
                
                return Redirect::route('maintenance.permission-denied.index')
                    ->with('message', $message)
                    ->with('messageType', $messageType); 
                
            }
            
        }
    }
    
});

/**
 * Filter to check if the URL Slug is valid
 *
 * @author Steve Bauman
 */
Route::filter('maintenance.valid.work-order', 'Stevebauman\Maintenance\Filters\WorkOrderFilter');

