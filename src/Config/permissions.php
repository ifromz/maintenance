<?php

/*
 * Default Permissions configuration file.
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
     * Worker permissions
     */
    'workers' => [

    ],

];
