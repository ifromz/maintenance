<?php 

namespace Stevebauman\Maintenance\Composers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

/*
 * Passes all the routes available to be selected to the route select box
 */
class RouteSelectComposer {
    
    public function compose($view){
        /*
         * Stores all the routes for selection, defaults are stored in config
         */
        $allRoutes = Config::get('maintenance::permissions.default');
        
        /*
         * Holds all the routes in the application
         */
        $routes = Route::getRoutes();
        
        foreach($routes as $route){
            
            /*
             * Make sure the route has a name
             */
            if($route->getName()){
                
                /*
                 * Get the route filters
                 */
                $filters = $route->beforeFilters();
                
                /*
                 * Make sure only routes guarded by the permission filter are shown
                 * in the route selection box
                 */
                if(array_key_exists('maintenance.permission', $filters)){
                    $allRoutes[$route->getName()] = $route->getName();
                }
            }
            
        }
        
        /*
         * Return the view with the routes for selection
         */
        return $view->with('allRoutes', $allRoutes);
    }
    
}
