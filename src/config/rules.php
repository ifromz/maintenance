<?php

/**
 * The maintenance application rules. The rules indicate the result of certain
 * functionality throughout the application.
 */
return array(

    /*
     * User rules
     */
    'users' => array(

        /*
         * If enabled, users will be sent an email when registering for an account, or and account
         * is created in the administration panel and 'activated' is not checked
         */
        'require_activation_by_email' => false,
    ),


    /*
     * Notification rules
     */
    'notifications' => array(

        /*
         * Set this to true if you would like to send a notification to the user
         * who caused the notification to be generated
         */
        'prevent_sending_to_source' => true,

    ),

    /*
     * Meter rules
     */
    'meters' => array(

        /*
         * Set this to true if you want to prevent a new reading from being created
         * if they equal the same number. This can be handy if you only want new
         * records when the reading actually changes.
         */
        'prevent_duplicate_entries' => true,

    ),

    /*
     * Work Order rules
     */
    'work-orders' => array(

        /*
         * Set enabled to true if you want to prevent a lot of work order updates
         * (technician or customer) from being created. Set the minutes apart
         * they must be submitted by.
         *
         * Ex. If a technician posts an update, he cannot create another update for
         * 5 minutes.
         *
         */
        'prevent_spam_updates' => array(
            'enabled' => 'true',
            'minutes_apart' => '5'
        )

    ),

    /*
     * Work Request rules
     */
    'work-requests' => array(

        /*
         * The status for the work order that's generated when a work request
         * is created
         */
        'submission_status' => array(
            'name' => 'Requested',
            'color' => 'default',
        ),

        /*
         * The priority for the work order that's generated when a work request
         * is created
         */
        'submission_priority' => array(
            'name' => 'Requested',
            'color' => 'default',
        ),

    ),
);