<?php

/*
 * Default Permissions configuration file.
 *
 * This file is used to seed group permissions when Maintenance is first installed.
 */
return [

    /*
     * All User permissions
     */
    'all' => [

        'maintenance.login' => 1,
        'maintenance.logout' => 1,
        'maintenance.register' => 1,
        'maintenance.register.why' => 1,
        'maintenance.permission-denied.index' => 1,

    ],

    /*
     *  Administrator permissions
     */
    'administrators' => [
        /*
         * Allows access to all site functions
         */
        'superuser' => 1,
    ],

    /*
     * Client Permissions
     */
    'clients' => [
        'maintenance.client.work-requests.index' => 1,
        'maintenance.client.work-requests.create' => 1,
        'maintenance.client.work-requests.store' => 1,
        'maintenance.client.work-requests.show' => 1,
        'maintenance.client.work-requests.edit' => 1,
        'maintenance.client.work-requests.update' => 1,
        'maintenance.client.work-requests.destroy' => 1,
    ],

    /*
     * Worker permissions
     */
    'workers' => [

    ],

];
