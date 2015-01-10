<?php

namespace Stevebauman\Maintenance\Composers;

/**
 * Class RouteSelectComposer
 * @package Stevebauman\Maintenance\Composers
 */
class RouteSelectComposer
{

    /**
     * @param $view
     * @return mixed
     */
    public function compose($view)
    {
        /*
         * Stores all the routes for selection, defaults are stored in config
         */
        $allRoutes = config('maintenance::permissions.default');

        /*
         * Holds all the routes in the application
         */
        $routes = Route::getRoutes();

        foreach ($routes as $route) {

            /*
             * Make sure the route has a name
             */
            if ($route->getName()) {

                /*
                 * Get the route filters
                 */
                $filters = $route->beforeFilters();

                /*
                 * Make sure only routes guarded by the permission filter are shown
                 * in the route selection box
                 */
                if (array_key_exists('maintenance.permission', $filters)) {
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
