<?php

namespace Stevebauman\Maintenance\Composers;

use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

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
    public function compose(View $view)
    {
        /*
         * Stores all the routes for selection, defaults are stored in config
         */
        $allRoutes = config('maintenance::permissions.default');

        /*
         * Get all the routes in the application
         */
        $routes = Route::getRoutes();

        foreach ($routes as $route) {

            $routeName = $route->getName();

            /*
             * Make sure the route has a name
             */
            if ($routeName) {

                /*
                 * Get the route filters
                 */
                $filters = $route->beforeFilters();

                /*
                 * Make sure only routes guarded by the permission filter are shown
                 * in the route selection box
                 */
                if (array_key_exists('maintenance.permission', $filters))
                {
                    /*
                     * Explode the route into segments
                     */
                    $segments = explode('.', $routeName);

                    if(count($segments) >= 1)
                    {
                        /*
                         * Pop the last segment off the route name
                         * so we can append a sentry wildcard to it ('*')
                         */
                        array_pop($segments);

                        /*
                         * Set the array pointer to the last element
                         */
                        end($segments);

                        /*
                         * Add the last element with the wildcard
                         */
                        $segments[] = '*';

                        /*
                         * Implode the array back into dot notation
                         */
                        $routeStar = implode('.', $segments);

                        /*
                         * Insert the route into the allRoutes array
                         */
                        $allRoutes[$segments[0]][$routeStar] = $routeStar;

                    }

                    /*
                     * We'll use the first segment entry to group the routes together
                     * for easier navigation
                     */
                    $allRoutes[$segments[0]][$routeName] = $routeName;

                }
            }
        }

        /*
         * Return the view with the routes for selection
         */
        return $view->with('allRoutes', $allRoutes);
    }

}
