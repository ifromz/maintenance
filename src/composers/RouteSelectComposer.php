<?php 

namespace Stevebauman\Maintenance\Composers;

use Illuminate\Support\Facades\Route;

class RouteSelectComposer {
    
    public function compose($view){
        $allRoutes = array();
        
        $routes = Route::getRoutes();

        foreach($routes as $route){
            
            if($route->getName()){
                $allRoutes[$route->getName()] = $route->getName();
            }
            
        }
        
        return $view->with('allRoutes', $allRoutes);
    }
    
}
