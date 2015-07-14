<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

// Enable CSRF protection on all post / put / delete routes
Route::when('*', 'csrf', ['post', 'put', 'delete']);

/*
 * Maintenance Application Routes
 */
Route::group(['prefix' => Config::get('maintenance.site.prefix'), 'namespace' => 'Stevebauman\Maintenance\Http'], function ()
{
    Route::get('/', ['as' => 'maintenance.welcome.index', 'uses' => 'Controllers\WelcomeController@index']);

    /*
     * Authentication Routes
     */
    include 'routes/auth.php';

    /*
     * Registration Routes
     */
    include 'routes/register.php';

    /*
     * Permission Routes (not allowed redirect)
     */
    include 'routes/permission.php';

    /*
     * Main Client Controller Group
     */
    Route::group(['prefix' => 'client', 'namespace' => 'Controllers', 'middleware' => ['maintenance.auth', 'maintenance.permission']], function ()
    {
        /*
         * Client Routes
         */
        include 'routes/client.php';
    });

    /*
     * Main Application Controller Group
     *
     * @filters
     *
     * Auth         - Only Allows logged in users
     * Permission   - Only Allows users with correct permissions
     */
    Route::group(['prefix' => 'management', 'namespace' => 'Controllers', 'middleware' => ['maintenance.auth', 'maintenance.permission']], function ()
    {
        /*
         * Dashboard Routes
         */
        include 'routes/dashboard.php';

        /*
         * Event Routes
         */
        include 'routes/event.php';

        /*
         * Work Request Routes
         */
        include 'routes/work-request.php';

        /*
         * Work Order Routes
         */
        include 'routes/work-order.php';

        /*
         * Asset Routes
         */
        include 'routes/asset.php';

        /*
         * Inventory Routes
         */
        include 'routes/inventory.php';

        /*
         * Attachment Routes (used for all attachments throughout the application)
         */
        include 'routes/attachment.php';

        /*
         * Location Routes
         */
        include 'routes/location.php';

        /*
         * Metric Routes
         */
        include 'routes/metric.php';

        /*
         * Administration Route Group
         */
        Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function ()
        {
            /*
             * Administration Routes
             */
            include 'routes/admin.php';
        });
    });
}); /* End Maintenance Routes */
