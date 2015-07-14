<?php

/*
 * Default Permissions configuration file.
 *
 * This file is used to seed group permissions when Maintenance is first installed.
 */
return [

    /*
     *  Administrator permissions
     */
    'administrators' => [
        /*
         * Allows access to all site functions
         */
        'superuser' => true,
    ],

    /*
     * Client Permissions
     */
    'clients' => [
        'maintenance.client.work-requests.index' => true,
        'maintenance.client.work-requests.create' => true,
        'maintenance.client.work-requests.store' => true,
        'maintenance.client.work-requests.show' => true,
        'maintenance.client.work-requests.edit' => true,
        'maintenance.client.work-requests.update' => true,
        'maintenance.client.work-requests.destroy' => true,

        'maintenance.client.work-requests.updates.store' => true,
        'maintenance.client.work-requests.updates.destroy' => true,
    ],

    /*
     * Worker permissions
     */
    'workers' => [

    ],

];
